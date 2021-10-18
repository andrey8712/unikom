<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 3.2//EN">
<html>
<head>
    <!--[if gte mso 9]>
    <xml>
        <o:OfficeDocumentsettings> 			<o:AllowPNG/> 			<o:PixelsPerInch>96</o:PixelsPerInch> 			</o:OfficeDocumentsettings>
    </xml>
    <![endif]-->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="format-detection" content="address=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="format-detection" content="email=no">
    <meta name="x-apple-disable-message-reformatting">
    <meta name="robots" content="noindex, nofollow">
</head>
<body>
<p align="center" size="18px"><b>Заявка №{{$order->id}} от {{now()->format('d.m.Y')}}</b></p>
<p size="16px">Прошу Вас отгрузить цементную продукцию</p>
<ul>
@foreach($order->products as $product)
        <li size="16px">
            <b>{{$product->product->title}} - {{$product->count}} тн.</b><br>
            с выгрузкой на {{$order->desired_date->addDay()->format('d.m.Y')}}.<br>
            Тип выгрузки: {{$order->getLoadingText()}}.<br>
            Адрес выгрузки: {{$order->city}}, {{$order->street}} {{$order->home}}.<br>
            Телефон: 89033995522
        </li>
@endforeach
</ul>
<p>
    С Уважением,<br>
    ООО "Уником"<br>
    Раб. тел.: +7 (3537) 67-16-24<br>
    Факс: +7 (3537) 67-55-41<br>
    Моб. тел.: +7-903-399-55-22<br>
    ICQ: 667004494<br>
    E-mail1: unikom56@mail.ru,<br>
    E-mail2: unikom56@gmail.com<br>
</p>
</body>
</html>