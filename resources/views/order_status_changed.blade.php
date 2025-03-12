<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Изменение статуса заказа</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; }
        .container { max-width: 600px; margin: auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); }
        .header { background: #007BFF; color: white; padding: 10px; text-align: center; font-size: 20px; border-radius: 10px 10px 0 0; }
        .content { padding: 20px; text-align: center; }
        .footer { margin-top: 20px; text-align: center; font-size: 12px; color: #888; }
        .button { background: #007BFF; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; display: inline-block; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Статус заказа изменен</div>
        <div class="content">
            <p>Здравствуйте!</p>
            <p>Статус вашего заказа <strong>#{{ $order->id }}</strong> изменен на:</p>
            <p><strong>{{ $order->status }}</strong></p>
            <a href="{{ url('/orders/' . $order->id) }}" class="button">Просмотреть заказ</a>
        </div>
        <div class="footer">Спасибо за покупку! Если у вас есть вопросы, свяжитесь с нами.</div>
    </div>
</body>
</html>