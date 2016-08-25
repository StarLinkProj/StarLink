<div class="container calcItOutsource">

	<h3>Как внедрять новейшие IT-технологии без большого и дорогостоящего IT-отдела?</h3>

	<p class="calcItOutsourceTopParagraph">Решение, которое мы предлагаем - передать обслуживание всей IT-инфраструктуры команде узкопрофильных специалистов. Рассчитайте стоимость абонентского обслуживания ПК и серверов.</p>

	<div id="connect_form">

		<table width="100%" class="tb-calc" cellpadding="0" cellspacing="0" align="center">
			<tr>
				<td width="15%" class="calcTdRangeNameText">КОЛИЧЕСТВО КОМПЬЮТЕРОВ</td>
				<td colspan="4" class="pt20">
					<div id="slider-pc-count"></div>
					<div id="slider-pc-count-digits">
						<?php for ($pcCountDigit = 0; $pcCountDigit <= 29; $pcCountDigit++) : ?>
							<span class="slider-pc-count-digit" data-pcDigit="<?=$pcCountDigit?>"><?=$pcCountDigit?></span>
						<?php endfor; ?>
					</div>
				</td>
			</tr>
			<tr>
				<td class="calcTdRangeNameText pt15">КОЛИЧЕСТВО ФИЗИЧЕСКИХ СЕРВЕРОВ</td>
				<td colspan="2" class="pt25" width="88%">
					<div id="slider-server-count"></div>
					<div id="slider-server-count-digits">
						<?php for ($serverCountDigit = 0; $serverCountDigit <= 15; $serverCountDigit++) : ?>
							<span class="slider-server-count-digit" data-serverDigit="<?=$serverCountDigit?>"><?=$serverCountDigit?></span>
						<?php endfor; ?>
					</div>
				</td>
				<td class="virtualServerNameText" width="25%">КОЛИЧЕСТВО ВИРТУАЛЬНЫХ СЕРВЕРОВ</td>
				<td class="pt25">
					<div id="slider-virtual-count"></div>
					<div id="slider-virtual-count-digits">
						<?php for ($serverCountDigit = 0; $serverCountDigit <= 7; $serverCountDigit++) : ?>
							<span class="slider-virtual-count-digit" data-virtualDigit="<?=$serverCountDigit?>"><?=$serverCountDigit?></span>
						<?php endfor; ?>
					</div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		</table>
		<table width="100%" class="tb-calc-bottom" cellpadding="0" cellspacing="0" align="center">
			<tr>
				<td width="20%"></td>
				<td width="20%" class="calcTdRangeNameText">
					<img src="/images/itOutsourcingCalcIcons/calcClockIcon.png" class="calcIconImg">
					ВРЕМЯ РЕАКЦИИ
				</td>
				<td width="20%" class="calcTdRangeNameText">
					<img src="/images/itOutsourcingCalcIcons/calcPersonIcon.png" class="calcIconImg">
					ВЫДЕЛЕННЫЙ ПЕРСОНАЛ
				</td>
				<td width="20%" class="calcTdRangeNameText">
					<img src="/images/itOutsourcingCalcIcons/calcVechicleIcon.png" class="calcIconImg">
					АВАРИЙНЫХ ВЫЕЗДОВ
				</td>
				<td width="20%" class="calcTdRangeNameText">
					<img src="/images/itOutsourcingCalcIcons/calcVechicleIcon.png" class="calcIconImg">
					ПЛАНОВЫХ ВЫЕЗДОВ
				</td>
			</tr>
			<tr>
				<td>
					<input type="radio" name="level" id="level1" value="0" class="r_button">
					<label for="level1"></label>
				</td>
				<td>
					1 час
				</td>
				<td>
					1 чел.
				</td>
				<td>
					НЕОГРАНИЧЕНО
				</td>
				<td>
					<span class="minus" id="minus1"></span>
					<input type="text" name="leavesCount1" id="leavesCount1" value="0" size="2" readonly="readonly">
					<span class="plus" id="plus1"></span>
				</td>
			</tr>
			<tr>
				<td>
					<input type="radio" name="level" id="level2" value="1" class="r_button">
					<label for="level2"></label>
				</td>
				<td>
					2 часа
				</td>
				<td>
					1 чел.
				</td>
				<td>
					НЕОГРАНИЧЕНО
				</td>
				<td>
					<span class="minus" id="minus1"></span>
					<input type="text" name="leavesCount2" id="leavesCount2" value="0" size="2" readonly="readonly">
					<span class="plus" id="plus1"></span>
				</td>
			</tr>
			<tr>
				<td>
					<input type="radio" name="level" id="level3" value="2" class="r_button">
					<label for="level3"></label>
				</td>
				<td>
					4 часа
				</td>
				<td>
					1 чел.
				</td>
				<td>
					1 ВЫЕЗД В МЕСЯЦ
				</td>
				<td>
					<span class="minus" id="minus1"></span>
					<input type="text" name="leavesCount3" id="leavesCount3" value="0" size="2" readonly="readonly">
					<span class="plus" id="plus1"></span>
				</td>
			</tr>
			<tr class="calcResultTr">
				<td class="calcTdRangeNameText">
					СТОИМОСТЬ ОБСЛУЖИВАНИЯ
				</td>
				<td>
					<input type="text" name="calcResult" id="calcResult" value="0" readonly="">
					<span class="currency">ГРН/МЕС</span>
				</td>
				<td colspan="3">
					<button type="submit" class="calcItOutsourceBtn btn submit-button" data-toggle="modal" data-target="#modalContactFormBlock">Заказать</button>
				</td>
			</tr>
		</table>

	<input type="hidden" name="pc_price" id="pc_price" value="<?php print_r($params->get('pc_price')); ?>"/>
	<input type="hidden" name="server_price" id="server_price" value="<?php print_r($params->get('server_price')); ?>"/>
	<input type="hidden" name="virtual_server_price" id="virtual_server_price" value="<?php print_r($params->get('virtual_server_price')); ?>"/>
	<input type="hidden" name="personal_device_price" id="personal_device_price" value="<?php print_r($params->get('personal_device_price')); ?>"/>
	<input type="hidden" name="additional_leave" id="additional_leave" value="<?php print_r($params->get('additional_leave')); ?>"/>
	<input type="hidden" name="kurs_euro" id="kurs_euro" value="<?php print_r($params->get('kurs_euro')); ?>"/>
	<input type="hidden" name="inflation_percent" id="inflation_percent" value="<?php print_r($params->get('inflation_percent')); ?>"/>

	<input type="hidden" id="pcCount">
	<input type="hidden" id="serverCount">
	<input type="hidden" id="virtualCount">
	</div>
</div>
