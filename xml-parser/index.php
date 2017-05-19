<!DOCTYPE>
<?
	require_once("model.php");
	$realty = new XMLdoc();
	$partners = $realty->getPartners();
	// foreach ($partners as $partner) :
	// endforeach;

?>
<HTML>
<HEAD>
	<link rel="stylesheet" href="style.css" />
</HEAD>
<BODY>
	<div style=" margin: 0 auto;">
	<? foreach ($partners as $partner) : 
		$realty->Load($partner->link);
		$realty->Validate();
		$realty->Compare($partner->partner_id);
		$realty->WriteInDB($partner->partner_id);
	?>
	<div style="width: 100%">
		<div class="partner_name"><?=$partner->partner?></div>
		<table>
		<thead>
			<tr>
				<th>ID</th>
				<th>Страна</th>
				<th>Валюта</th>
				<th>Цена</th>
				<th>Площадь</th>
				<th>Тип сделки</th>
				<th>Тип недвижимости</th>
				<th>Подтип недвижимости</th>
				<th>Первичное/вторичное</th>
				<th>Широта</th>
				<th>Долгота</th>
				<th>Адрес</th>
			</tr>
		</thead>
		<tbody>
			<? foreach ($realty->xmlFile as $item) : ?>
			<tr>
				<td><?=$item->id?></td>
				<td><?=$item->country?></td>
				<td><?=$item->currency?></td>
				<td><?=$item->price?></td>
				<td><?=$item->area?></td>
				<td><?=$item->deal?></td>
				<td><?=$item->type?></td>
				<td><?=$item->subtype?></td>
				<td><?=$item->grp?></td>
				<td><?=$item->lat?></td>
				<td><?=$item->longt?></td>
				<td><?=$item->adress?></td>
			</tr>
			<? endforeach; ?>
		</tbody>
		</table>
	</div>
	<? endforeach;?>
	</div>
</BODY>
</HTML>