<div class="container calcItOutsource">

	<h3>Как внедрять новейшие IT-технологии без большого и дорогостоящего IT-отдела?</h3>

	<p class="calcItOutsourceTopParagraph">Решение, которое мы предлагаем - передать обслуживание всей IT-инфраструктуры команде узкопрофильных специалистов. Рассчитайте стоимость абонентского обслуживания ПК и серверов.</p>

	<div id="connect_form">

		<table width="900" class="tb-calc" cellpadding="0" cellspacing="0" align="center">
			<tr>
				<td width="100px" class="td-padding-bottom-first-tr tooltip-own"><strong>количество компютеров</strong><em>Подсказка для пункта "количество компютеров"<i class="left"></i><i class="right"></i></em></td>
				<td width="120px" class="td-padding-bottom-first-tr tooltip-own"><strong>количество серверов</strong><em>Подсказка для пункта "количество серверов"<i class="left"></i><i class="right"></i></em></td>
				<td width="105px" class="td-padding-left td-padding-bottom-first-tr tooltip-own"><strong>выберите обслуживание</strong><em>Подсказка для пункта "выберите обслуживание"<i class="left"></i><i class="right"></i></em></td>
				<td width="90px" class="td-padding-bottom-first-tr tooltip-own">время реакции<em>Подсказка для пункта "время реакции"<i class="left"></i><i class="right"></i></em></td>
				<td width="95px" class="td-padding-bottom-first-tr tooltip-own">выделенный персонал<em>Подсказка для пункта "выделенный персонал"<i class="left"></i><i class="right"></i></em></td>
				<td width="105px" class="td-padding-bottom-first-tr tooltip-own">аварийных выездов<em>Подсказка для пункта "аварийных выездов"<i class="left"></i><i class="right"></i></em></td>
				<td width="110px" class="td-padding-bottom-first-tr tooltip-own">плановых выездов<em>Подсказка для пункта "плановых выездов"<i class="left"></i><i class="right"></i></em></td>
				<td class="td-padding-bottom-first-tr tooltip-own"><strong>стоимость обслуживания</strong><em>Подсказка для пункта "стоимость обслуживания"<i class="left"></i><i class="right"></i></em></td>
			</tr>
			<tr>
				<td>
					<div class="pc_count_div tooltip-own-img">
						<input type="text" id="pcCount" />
						<em>Подсказка для пункта "количество компютеров" для изображения<i class="left"></i><i class="right"></i></em>
					</div>
				</td>
				<td>
					<div class="server_count_div tooltip-own-img">
						<input type="text" id="serverCount" />
						<em>Подсказка для пункта "количество серверов" для изображения<i class="left"></i><i class="right"></i></em>
					</div>
				</td>
				<td  class="td-padding-left">
					<div class="service_level_div tooltip-own-img">
						<em>Подсказка для пункта "выберите обслуживание" для изображения<i class="left"></i><i class="right"></i></em>
					</div>
				</td>
				<td>
					<div class="reaction_time_div tooltip-own-img">
						<em>Подсказка для пункта "время реакции" для изображения<i class="left"></i><i class="right"></i></em>
					</div>
				</td>
				<td>
					<div class="chosen_personal_div tooltip-own-img">
						<em>Подсказка для пункта "выделенный персонал" для изображения<i class="left"></i><i class="right"></i></em>
					</div>
				</td>
				<td>
					<div class="avar_leaves_div tooltip-own-img">
						<em>Подсказка для пункта "аварийных выездов" для изображения<i class="left"></i><i class="right"></i></em>
					</div>
				</td>
				<td>
					<div class="plan_leaves_div tooltip-own-img">
						<em>Подсказка для пункта "плановых выездов" для изображения<i class="left"></i><i class="right"></i></em>
					</div>
				</td>
				<td>
					<div class="result_div tooltip-own-img">
						<em>Подсказка для пункта "стоимость обслуживания" для изображения<i class="left"></i><i class="right"></i></em>
					</div>
				</td>
			</tr>
			<tr>
				<td rowspan="4">
					<div id="slider-pc-count" style="height: 260px;"></div>
				</td>
				<td height="85px">
					<div id="slider-server-count" style="height: 60px;"></div>
				</td>
				<td colspan="5" rowspan="4" class="td-padding-left">
					<div class="service-level">
						<div class="level-1 levels">
							<table id="tableLevel1" cellpadding="0" cellspacing="0" align="center">
								<tr>
									<td width="98px">
										<input type="radio" name="level" id="level1" value="0" class="r_button" />
										<label for="level1"></label>
									</td>
									<td width="93px">
										1 <span class="un-upper">час</span>
									</td>
									<td width="100px">
										2 <span class="un-upper">чел.</span>
									</td>
									<td width="110px">
										неограничено
									</td>
									<td style="padding-left: 4px;">
										<span class="minus" id="minus1"></span>
										<input type="text" name="leavesCount1" id="leavesCount1" value="4" size="2" readonly="readonly" />
										<span class="plus" id="plus1"></span>
									</td>
								</tr>
							</table>
						</div>
						<div class="level-2 levels">
							<table id="tableLevel2" cellpadding="0" cellspacing="0" align="center">
								<tr>
									<td width="98px">
										<input type="radio" name="level" id="level2" value="1" class="r_button" />
										<label for="level2"></label>
									</td>
									<td width="93px">
										2 <span class="un-upper">часа</span>
									</td>
									<td width="100px">
										1 <span class="un-upper">чел.</span>
									</td>
									<td width="110px">
										неограничено
									</td>
									<td style="padding-left: 4px;">
										<span class="minus" id="minus2"></span>
										<input type="text" name="leavesCount2" id="leavesCount2" value="2" size="2" readonly="readonly" />
										<span class="plus" id="plus2"></span>
									</td>
								</tr>
							</table>
						</div>
						<div class="level-3 levels">
							<table id="tableLevel3" cellpadding="0" cellspacing="0" align="center">
								<tr>
									<td width="98px">
										<input type="radio" name="level" id="level3" value="2" class="r_button" />
										<label for="level3"></label>
									</td>
									<td width="93px">
										3 <span class="un-upper">часа</span>
									</td>
									<td width="100px">
										1 <span class="un-upper">чел.</span>
									</td>
									<td width="110px">
										1/месяц
									</td>
									<td style="padding-left: 4px;">
										<span class="minus" id="minus3"></span>
										<input type="text" name="leavesCount3" id="leavesCount3" value="1" size="2" readonly="readonly" />
										<span class="plus" id="plus3"></span>
									</td>
								</tr>
							</table>
						</div>
					</div>
				</td>
				<td rowspan="4">
					<input type="text" name="calcResult" id="calcResult" value="0" readonly />
					<div class="currency">грн/мес</div>
					<div class="discount">скидки</div>
				</td>
			</tr>
			<tr>
				<td height="30px"><strong>из них виртуальных</strong></td>
			</tr>
			<tr>
				<td height="80px">
					<div class="virtual_count_div tooltip-own-img">
						<input type="text" id="virtualCount" />
						<em>Подсказка для пункта "количество виртуальных серверов" для изображения<i class="left"></i><i class="right"></i></em>
					</div>
				</td>
			</tr>
			<tr>
				<td height="85px">
					<div id="slider-virtual-count" style="height: 60px;"></div>
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
	</div>
</div>