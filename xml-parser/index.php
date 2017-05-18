<!DOCTYPE>
<?
	require_once("model.php");
	$realty = new XMLdoc();
	$partners = $realty->getPartners();
	foreach ($partners as $partner) :
		$realty->Load($partner->link);
		$realty->Validate();
		$realty->Compare($partner->partner_id);
		$realty->WriteInDB($partner->partner_id);
	endforeach;

?>
<HTML>
<HEAD>
	
</HEAD>
<BODY>
	
</BODY>
</HTML>