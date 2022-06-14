<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Analyzes;
use App\Models\Course;
use App\Models\DigitalImages;
use App\Models\Law;
use App\Models\News;
use App\Http\Requests\ContactRequest;
use App\Models\Partner;
use App\Models\Program;
use App\Models\Reports;
use App\Models\Setting;
use App\Models\Staff;
use App\Services\AboutUsService;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function index()
    {
        $news = News::orderBy('date', 'desc')->limit(4)->get();
        $slider = Setting::getHomeSliders();
        $mainCourse = Course::where('is_main', 1)->first();
        $courses = Course::where('is_main', 0)->limit(3)->orderBy('created_at', 'desc')->get();
        $members = Partner::with("image")->where('is_partner', 0)->get();
        return view('front.home', compact('news', 'slider', 'mainCourse', 'courses', 'members'));
    }

    public function contactUs()
    {
        $mapAddress = Setting::getByKey('map_address');
        $emailAddress = Setting::getByKey('email');
        $phoneNumber = Setting::getByKey('phone_number');
        return view('front.contact', compact('mapAddress', 'emailAddress', 'phoneNumber'));
    }

    public function sendContactEmail(ContactRequest $request)
    {
        try {
            $emailContent = "<h1>Name: " . $request->get('name') . "</h1>
                            </br>
                            <h2>Email: " . $request->get('email') . "</h2>
                            </br>
                            <p>" . $request->get('message') . "</p>";

            Mail::mailer()->send([], [], function ($message) use ($emailContent) {
                $from = config('mail.from');
                $message->from($from['address'], $from['name']);
                $message->to(config('mail.contact.to'), config('mail.contact.to'))
                    ->subject('Contact')
                    ->setBody($emailContent, 'text/html');
            });

            return redirect()->back()->with(['message' => 'Contact form sent successfully!']);
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors(['message' => 'Contact form sending process failed!']);
        }
    }

    public function legislation()
    {
        $laws = Law::where('type', Law::TYPE_LAW)->get();
        $regulations = Law::where('type', Law::TYPE_REGULATION)->get();
        return view('front.legislation', compact('laws', 'regulations'));
    }

    public function reports()
    {
        $reports = Reports::all();
        return view('front.reports', ['reports' => $reports]);
    }

    public function digitalImages()
    {
        $digitalImages = DigitalImages::with('attachment')->get();
        return view('front.digital-images', compact('digitalImages'));
    }

    public function analyzes()
    {
        $analyzes = Analyzes::with('attachment')->paginate(5);
        return view('front.analyzes', compact('analyzes'));
    }

    public function aboutUS()
    {
        $links = AboutUsService::getLinks();
        $aboutContent = AboutUsService::getContent();
        $partners = Partner::where('is_partner', 1)->get();
        $members = Partner::where('is_partner', 0)->get();
        $staffs = Staff::with('attachment')->get();
        return view('front.about-us', compact('links', 'aboutContent', 'partners', 'members', 'staffs'));
    }

    public function programs()
    {
        $programs = Program::with('attachment')->paginate(5);
        return view('front.programs', compact('programs'));
    }

    public function member(Partner $member)
    {
        return view('front.member', compact('member'));
    }
}
