<?php

namespace App\Http\Controllers\Front;

use Mail;
use App\Models\FormResponse;
use App\Http\Controllers\Controller;
use App\Models\Enums\SpecialArticle;
use App\Mail\Admin\ContactFormSubmitted;
use App\Http\Requests\Front\FormResponseRequest;

class ContactController extends Controller
{
    public function index()
    {
        $article = article(SpecialArticle::CONTACT);

        return view('front.contact.index', compact('article'));
    }

    public function handleResponse(FormResponseRequest $request)
    {
        $formResponse = FormResponse::create($request->except(['g-recaptcha-response']));

        Mail::send(new ContactFormSubmitted($formResponse));

        activity()->log("{$formResponse->email} vulde het contactformulier in");

        flash()->success(__('contact.response'));

        return redirect()->action('Front\ContactController@index');
    }
}
