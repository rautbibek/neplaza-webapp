@extends('layouts.email')
@section('content')
    <table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="ffffff" class="bg_color">

        <tr>
            <td align="center">
                <table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590">

                    <tr>
                        <td align="center" style="color: #343434; font-size: 24px; font-family: Quicksand, Calibri, sans-serif; font-weight:700;letter-spacing: 3px; line-height: 35px;"
                            class="main-header">
                            <!-- section text ======-->

                            <div style="line-height: 35px">

                                Urgent product <span style="color: #5caad2;">Notification</span>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
                    </tr>

                    <tr>
                        <td align="center">
                            <table border="0" width="40" align="center" cellpadding="0" cellspacing="0" bgcolor="eeeeee">
                                <tr>
                                    <td height="2" style="font-size: 2px; line-height: 2px;">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td height="20" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
                    </tr>

                    <tr>
                        <td align="left">
                            <table border="0" width="590" align="center" cellpadding="0" cellspacing="0" class="container590">
                                <tr>
                                    <td align="left" style="color: #888888; font-size: 16px; font-family: 'Work Sans', Calibri, sans-serif; line-height: 24px;">
                                        <!-- section text ======-->

                                        <p style="line-height: 24px; margin-bottom:15px;">
                                        Hi,
                                        <?php
                                            $name = explode(' ',trim($p->user->name));
                                            echo $name[0];
                                          ?>,

                                        </p>
                                        <p style="line-height: 24px;margin-bottom:15px;">
                                        This e-mail is to remind that your Urgent listing of product in <a href="{{env('APP_URL')}}">{{env('APP_NAME')}}</a> is going to expire in 3 days.
                                        </p>

                                        
                                        
                                        <table border="0" align="center" width="180" cellpadding="0" cellspacing="0" bgcolor="5caad2" style="margin-bottom:20px;">

                                            <tr>
                                                <td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
                                            </tr>
                                            
                                            <tr>
                                                <p><strong>Ad Detail:</strong></p>
                                                <td align="center" style="color: #ffffff; font-size: 14px; font-family: 'Work Sans', Calibri, sans-serif; line-height: 22px; letter-spacing: 2px;">
                                                    <!-- main section button -->
                                                    
                                                    <div style="line-height: 22px;">
                                                        <a href="{{config('app.url').'/ad/detail/'.$p->id.'/'.$p->slug}}" style="color: #ffffff; text-decoration: none;">{{$p->productid}}</a>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
                                            </tr>
                                            
                                        </table>
                                        <p style="line-height: 24px;margin-bottom:15px;">
                                        Kindly visit the website to renew/ remove the listing(s). 
                                        If no action is taken, the listing will automatically be removed from the website after the expiry of the period.

                                        </p>
                                        
                                        <p>
                                            Thanks
                                        </p>
                                        <span>{{env('APP_NAME')}}</span>
                                        <br><br>
                                        <strong>Note: This is a system generated mail. Do not reply to this email.</strong>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>
    @endsection




