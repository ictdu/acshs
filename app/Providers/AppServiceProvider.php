<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\Page_content;
use App\Carousel;
use App\Logo;
use App\School;
use App\About;
use App\Message;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /*if (Schema::hasTable('messages')) {
            $unreadMessage = 0;
            $messages = Message::where('seen', 0)->get();
            if ($messages->count() > 0) {
                foreach ($messages as $row) {
                    $unreadMessage++;
                }
            }
            view()->share('unreadMessage', $unreadMessage);
        }*/

        if (Schema::hasTable('page_contents')) {
            $checkIfPageContentIsEmpty = false;
            $checkPageContent = Page_content::all();
            if($checkPageContent->count() <= 0){
                $checkIfPageContentIsEmpty = true;
            }
            
            $web_details = Page_content::orderBy('updated_at', 'desc')->first();
            view()->share('web_details', $web_details);
            view()->share('checkIfPageContentIsEmpty', $checkIfPageContentIsEmpty);
        }

        // carousel
        if (Schema::hasTable('carousels')) {
            $carouselCounter = 0;
            $carouselEmpty = false;
            $carousels = Carousel::all();
            if ($carousels->count() <= 0) {
                $carouselEmpty = true;
            }

            $carousels = Carousel::orderBy('created_at', 'desc')->paginate(3);
            $fCarousel = Carousel::orderBy('created_at', 'desc')->paginate(1)->first();
            view()->share('carouselCounter', $carouselCounter);
            view()->share('carousels', $carousels);
            view()->share('fCarousel', $fCarousel);
            view()->share('carouselEmpty', $carouselEmpty);
        }

        // logo
        if (Schema::hasTable('logo')) {
            $logoEmpty = false;
            $logos = Logo::all();
            if ($logos->count() <= 0) {
                $logoEmpty = true;
            }

            $publicLogo = Logo::orderBy('created_at', 'desc')->paginate(1)->first();
            view()->share('publicLogo', $publicLogo);
            view()->share('logoEmpty', $logoEmpty);
        }

        // schoolname
        if (Schema::hasTable('schoolname')) {
            $schoolnameEmpty = false;
            $schoolnames = School::all();
            if ($schoolnames->count() <= 0) {
                $schoolnameEmpty = true;
            }

            $publicSchoolname = School::orderBy('created_at', 'desc')->paginate(1)->first();
            view()->share('publicSchoolname', $publicSchoolname);
            view()->share('schoolnameEmpty', $schoolnameEmpty);
        }

        // about
        if (Schema::hasTable('about')) {
            $aboutEmpty = false;
            $abouts = About::all();
            if ($abouts->count() <= 0) {
                $aboutEmpty = true;
            }

            $publicAbout = About::orderBy('created_at', 'desc')->paginate(1)->first();
            view()->share('publicAbout', $publicAbout);
            view()->share('aboutEmpty', $aboutEmpty);
        }

        Schema::defaultStringLength(191);
        
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
