<?php

$apiKey = "d7ee1ab7adb1d5b009a10988baf0bd59";
$city = "Yalta";
$url = "http://api.openweathermap.org/data/2.5/forecast?q=" . $city . "&cnt&lang=ru&units=metric&appid=" . $apiKey;

$ch = curl_init($url); //создание запроса
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //возврат данных из curl_exec()
$data = json_decode(curl_exec($ch)); // декодирование json и сохранение данных
curl_close($ch); //завершение сеанса

$list = $data -> list; //в этом свойстве нужные данные
$tmpArr = [];
$humArr = [];
$clearCnt = 0;

foreach ($list as $obj) {
    $tmpArr[] = $obj -> main -> temp; //заполняем массив температур
    $humArr[] = $obj -> main -> humidity;//заполняеи массив влажностей
    if ($obj -> weather[0] -> main === "Clear") {
        $clearCnt++; //считаем кол-во "ясно"
    }
}

$sky = $clearCnt > 20 ? "ясно" : "пасмурно";

sort($tmpArr);
$maxTmp = $tmpArr[39];
$minTmp = $tmpArr[0];
$medianTmp = ($tmpArr[19]+$tmpArr[20])/2;

sort($humArr);
$maxHum = $humArr[39];
$minHum = $humArr[0];
$medianHum = ($humArr[19]+$humArr[20])/2;
?>


<div class="weather">
    <h2>Погода в городе <?php echo $city; ?> на протяжении ближайших 5 дней</h2>
    <p>Максимальная температура: <?php echo $maxTmp; ?> °C</p>
    <p>Минимальная температура: <?php echo $minTmp; ?> °C</p>
    <p>Медианная температура: <?php echo $medianTmp; ?> °C</p>
    <p>Максимальная влажность: <?php echo $maxHum; ?> %</p>
    <p>Минимальная влажность: <?php echo $minHum; ?> %</p>
    <p>Медианная влажность: <?php echo $medianHum; ?> %</p>
    <p>В основном <?php echo $sky ?> </p>
</div>

