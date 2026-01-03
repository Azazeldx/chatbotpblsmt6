<?php

namespace App\Http\Controllers;

use App\Http\Requests\MailRequest;
use App\Mail\TestMail;
use App\Models\Article;
use App\Models\Sponsor;
use App\Models\Category;
use App\Models\Page;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

class HomeController extends Controller
{
    public function index()
    {
        $data = $this->data();
        $data['weather'] = WeatherController::getWeatherData();
        return view('pages.index', compact('data'));
    }

    public function search(Request $request)
    {
        $data = $this->data();
        $data['categories'] = Category::where('searchable', 1)->get();
        $data['tags'] = Tag::withoutTrashed()->get();

        $tmp = Article::query();
        $tmp = $tmp->whereNotNull('published_at')->where('private', 0);

        $tmp = $tmp->whereHas('category', function ($query) use ($request) {
            if ($request->input('category')) {
                $query->where('slug', $request->input('category'));
            } else {
                $query->where('default', 1);
            }
            $query->where('searchable', 1);
        });

        if ($request->filled('tags')) {
            $selected = explode(',', $request->tags);
            $tmp->whereHas('tags', function ($q) use ($selected) {
                $q->whereIn('slug', $selected);
            }, '=', count($selected));
        }

        if ($request->filled('search')) {
            $tmp->where('title', 'like', '%'.$request->search.'%');
        }

        $data["result"] = $tmp->orderBy('published_at', 'desc')->paginate(16)->withQueryString();
        return view('pages.search', compact('data', 'request'));
    }

    public function detail(string $category, string $slug)
    {
        $data = config('general-settings');
        $data['category'] = Category::where('slug', $category)->firstOrFail();
        $data['article'] = Article::where('slug', $slug)->whereNotNull('published_at')->firstOrFail();

        $data['related'] = Article::query()
            ->where('id', "!=", $data['article']->id) 
            ->where('category_id', "=", $data['article']->category_id) 
            ->whereNotNull('published_at') 
            ->latest('published_at')    
            ->take(5) 
            ->get();

        if ($data['features']['sponsors']) {
            $data['sponsors'] = $data['article']->sponsors()->with('category')->get()->sortBy(function ($item) {
                return $item->category->sort_order ?? 999;
            });
        }

        // Pastikan view path-nya benar
        return view('pages.details.'.$data['category']->detail_page, compact('data'));
    }

    public function mail(MailRequest $request)
    {
        $validated = $request->validated();

        try {
            Mail::to($validated['email'])
                ->send(new TestMail([
                    'subject' => $validated['subject'],
                    'body' => $validated['message'],
                ]));
            return back()->with('success', 'Pesan berhasil dikirim!');
        } catch (\Exception $e) {
            return back()->with('danger', 'Pesan gagal dikirim!');
        }
    }
}
