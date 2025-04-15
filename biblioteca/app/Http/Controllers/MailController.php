<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailPadrao;


class MailController extends Controller
{
    public function enviarEmail()
    {
        Mail::to('jppburn@gmail.com')->send(new EmailPadrao());
    }
}
