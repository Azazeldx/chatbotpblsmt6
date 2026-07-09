<?php

namespace App\Providers;

use App\Models\GeneralSetting;
use App\Models\Page;
use App\Models\Section;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 1. Listen for changes to clear the cache automatically
        $clearCache = function () {
            Cache::forget('app_general_settings_data');
        };
        GeneralSetting::saved($clearCache);
        Page::saved($clearCache);
        Section::saved($clearCache);
        GeneralSetting::deleted($clearCache);
        Page::deleted($clearCache);
        Section::deleted($clearCache);

        // 2. Cache the heavy database query processing permanently
        $data = Cache::rememberForever('app_general_settings_data', function () {
            try {
                $setting = GeneralSetting::select([
                    'site_name',
                    'site_description',
                    'site_logo',
                    'site_favicon',
                    'site_url',
                    'site_dashboard_url',
                    'location',
                    'contacts',
                    'theme',
                    'email_settings',
                    'social_network',
                    'navigation',
                    'features',
                    'ai',
                    'google_analytics',
                    'user_features',
                ])->first();

                if (!$setting) return [];
                
                $data = $setting->toArray();

                // navigation
                $navigation = $data['navigation'] ?? [];

                $navigation['header'] = $navigation['header'] ?? null;
                $navigation['footer'] = $navigation['footer'] ?? null;
                $navigation['search'] = $navigation['search'] ?? null;
                $navigation['home'] = $navigation['home'] ?? null;
                $navigation['nav_items'] = $navigation['nav_items'] ?? [];

                // Ambil semua Sections yang dibutuhkan dalam 1 query
                $sectionIds = array_filter([$navigation['header'], $navigation['footer']]);
                $sections = Section::whereIn('id', $sectionIds)->get()->keyBy('id');
                $navigation['header'] = $sections->get($navigation['header'])?->toArray();
                $navigation['footer'] = $sections->get($navigation['footer'])?->toArray();

                // Kumpulkan semua ID Page yang dibutuhkan
                $pageIds = array_filter([$navigation['search'], $navigation['home']]);
                foreach ($navigation['nav_items'] as $value) {
                    if ($value['type'] == 'page' && !empty($value['page'])) {
                        $pageIds[] = $value['page'];
                    }
                }
                
                // Ambil semua Pages dalam 1 query
                $pages = Page::whereIn('id', $pageIds)->get()->keyBy('id');
                
                $navigation['search'] = $pages->get($navigation['search'])?->toArray();
                $navigation['home'] = $pages->get($navigation['home'])?->toArray();

                foreach ($navigation['nav_items'] as $key => $value) {
                    if ($value['type'] == 'page') {
                        $page = $pages->get($value['page']);
                        if ($page) {
                            $navigation['nav_items'][$key]['page'] = $page->toArray();
                        } else {
                            unset($navigation['nav_items'][$key]);
                        }
                    } elseif ($value['type'] == 'link') {
                        if (empty($value['link']['url']) || empty($value['link']['label'])) {
                            unset($navigation['nav_items'][$key]);
                        }
                    }
                }

                $data['navigation'] = $navigation;
                
                return $data;
            } catch (\Exception $e) {
                return [];
            }
        });

        if (empty($data)) {
            return;
        }

        // app url
        Config::set('app.url', $data['site_url'] ?? env('APP_URL'));

        // theme
        foreach ($data['theme'] as $keyColor => $color) {
            if ($color) {
                foreach ($color as $keyShade => $shade) {
                    $data['theme'][$keyColor][$keyShade] = str_replace(',', '', $shade);
                }
            }
        }

        // general-settings
        Config::set('general-settings', array_intersect_key($data, array_flip([
            'site_name',
            'site_description',
            'site_logo',
            'site_favicon',
            'site_dashboard_url',
            'location',
            'contacts',
            'theme',
            'social_network',
            'navigation',
            'features',
            'ai',
            'user_features',
        ])));

        // analytics.property_id
        $analytics = $data['google_analytics'] ?? [];
        Config::set('analytics.property_id', $analytics['google_property_id'] ?? null);
        Config::set('analytics.analytics_tag', $analytics['google_analytics_tag'] ?? null);
        unset($analytics);

        // mail
        $mail = $data['email_settings'] ?? [];
        Config::set([
            'mail.default' => $mail['default_email_provider'] ?? 'log',
            'mail.mailers.smtp.host' => $mail['smtp_host'] ?? '127.0.0.1',
            'mail.mailers.smtp.port' => $mail['smtp_port'] ?? 2525,
            'mail.mailers.smtp.encryption' => $mail['smtp_encryption'] ?? 'tls',
            'mail.mailers.smtp.username' => $mail['smtp_username'] ?? null,
            'mail.mailers.smtp.password' => $mail['smtp_password'] ?? null,
            'mail.mailers.smtp.timeout' => $mail['smtp_timeout'] ?? null,
            'mail.from.address' => $mail['email_from_address'] ?? 'hello@example.com',
            'mail.from.name' => $mail['email_from_name'] ?? 'Example',
        ]);
        unset($mail);

        unset($data);

        // dd(config('general-settings'));
    }
}
