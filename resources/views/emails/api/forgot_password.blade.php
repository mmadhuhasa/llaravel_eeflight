@extends('emails.layout')
@section('container')
<table border="0" cellpadding="0" cellspacing="0" width="100%"  >
    <tr>
        <td>
            <table border="0" width="600" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="color:#333333 !important; font-size:20px; font-family: monospace; padding-left:10px;" height="40">
                        <div align="center" style="font: 14px normal monospace;">
                            <div align="left" style="width: 700px;
                                 margin: auto;
                                 background-color: #eaeaea;
                                 border-radius: 10px;
                                 padding: 5px;">
                                <div align="center">
                                    <h1 align="left" style="font-size: 18px;
                                        font-weight: normal;
                                        width: 95%;
                                        background-color:#f1292b;filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#f1292b', endColorstr='#f37858');background: -webkit-gradient(linear, left top, left bottom, from(#f1292b), to(#f37858)); /* for webkit browsers */
                                        background: -moz-linear-gradient(top, #f1292b, #f37858); color: #fff;
                                        border-radius: 8px;
                                        padding: 10px;">
                                        <span style="color:white;font-family: monospace">Reset Password</span>                                        
                                    </h1>
                                    <div align="left" style="width: 95%;
                                         padding: 9px;
                                         border: 2px dashed #c2c2c2;
                                         background-color: white;
                                         border-radius: 10px;">
                                        <p style="font-size:15px ;font-family: monospace;color: black;">
                                            Dear {{$name.","}}<br/> <br/> 
                                            We have received a request to reset password for EFLIGHT website & APP.
                                            Please click on the below button to set New Password.<br/>
                                           
                                            <a href="{{$url.'/password/reset/?_key='.$encoded }}" style="width: 153px;
                                               margin: 25px 0 auto;
                                               background-color: #333;
                                               text-align: center;
                                               border: #333 solid 1px;
                                               padding: 8px 0;
                                               text-decoration: none;
                                               display: block;">
                                                <span style="color: white;font-size: 14px;">Reset Password</span></a><br/>
                                            If You have not requested change of password, please contact us over phone or email immediately.



                                        </p><br/>
                                        <p style="font-size:15px ;font-family: monospace;color: black;">
                                            <span style="color: #404040;">						
                                                Thanks & Regards, <br/> <br/> 
                                                <span style="color: red"> TEAM EFLIGHT </span><br/> 
                                                (+91) 9449485515<br/> 
                                            </span>                                           
                                        </p>
                                    </div>
                                    <br/>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
@stop
