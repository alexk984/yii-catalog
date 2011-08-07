<?php
	$cs = Yii::app()->getClientScript();
//	$cs->registerScriptFile('http://api-maps.yandex.ru/1.1/index.xml?key=ACmweE0BAAAAhZxjRQIASQkh3X_UYxcmtJkS6jd62GIg1bcAAAAAAAAAAAAYBaGJhgtpGTM9QP-_yB0l_38vbw==');
//	$cs->registerScript('ya-map', 'window.onload = function () {
//		var map = new YMaps.Map(document.getElementById("YMapsID"));
//		map.addControl(new YMaps.TypeControl());
//		map.addControl(new YMaps.ToolBar());
//		map.addControl(new YMaps.Zoom());
//		map.addControl(new YMaps.MiniMap());
//		map.addControl(new YMaps.ScaleLine());
//		map.setCenter(new YMaps.GeoPoint(44.615456,48.81745), 14);
//
//		var placemark = new YMaps.Placemark(new YMaps.GeoPoint(44.621593,48.816317),
//		{style:"default#hospitalIcon",
//		draggable: 1,
//		    hintOptions: {
//			maxWidth: 100,
//			showTimeout: 200,
//		    },
//		    balloonOptions: {
//			maxWidth: 250,
//		    }
//		});
//
//		// Устанавливает содержимое балуна
//		placemark.name = "hi!";
//		placemark.description = "Здесь я живу";
//		placemark.setBalloonContent("<div class=\"alex-baloon\"><span>Здесь я живу :)</span></div>");
//		//placemark.maxWidth("100px");
//
//		// Добавляет метку на карту
//		map.addOverlay(placemark);
//        }');
//<div id="YMapsID" style="width:600px;height:400px;float:left;"></div>
?>
<div class="clearfix">
    <div class="fll">Этот проект я посвещаю своей второй половинке :)<br>
        <img src="http://cs9193.vkontakte.ru/u36669807/a_bc3ab3dc.jpg" alt="Любимая" />
    </div>
    <div class="about-me">
        <h2>Обо мне</h2>
        <p><strong>Kireev Alex</strong></p>
        <p><strong>email:</strong> alexk984@gmail.com</p>
        <p><strong>Занимаюсь</strong> веб-разработкой, используя следующие языки и фреймворки: <br> Yii-framework, php,
            mysql, html, css, sass, javascript, ajax, jquery, немного рисую в photoshop.</p>
        <p><strong>Где найти</strong></p>
        <ul>
            <li><a href="http://yiiframework.ru/forum/memberlist.php?mode=viewprofile&u=1173">Yii-framework forum</a></li>
            <li><a href="http://www.free-lance.ru/users/dampel4">Free-lance</a></li>
            <li><a href="http://vkontakte.ru/kireev.alex">VKontakte</a></li>
        </ul>
    </div>
</div>
