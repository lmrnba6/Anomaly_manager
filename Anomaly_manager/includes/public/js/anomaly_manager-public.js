function test(choixIn,choixOut)
{
	x=choixIn[0];
	y=choixOut;
	var $j = jQuery.noConflict();
	var boxWidth = $j(".blog").width();
	var boxHeight = $j(".blog").height();
	var sousboxWidth = 430;
	var sousboxHeight = 294;
	
	y.style.display='none';
	
		if(y.id=="choix2")
		{
			if(x.id =="choix1")
			{
				$j(".blog").animate
				({
					width: 0,
					height:0
				});
				$j("#divhome").animate
				({
					width: 0,
					height:0
				});
				$j("#divliste").animate
				({
					width: sousboxWidth ,
					height: sousboxHeight
				});
				$j(".blog").animate
				({
					width: boxWidth ,
					height:boxHeight
				});
				document.getElementById("divhome").style.display= 'none';
			}
			else if(x.id =="choix3")
			{
				$j(".blog").animate
				({
					width: 0,
					height:0
				});
				$j("#divmodif").animate
				({
					width: 0,
					height:0
				});
				$j("#divliste").animate
				({
					width: sousboxWidth ,
					height: sousboxHeight
				});
				$j(".blog").animate
				({
					width: boxWidth ,
					height:boxHeight
				});
				document.getElementById("divmodif").style.display= 'none';
			}
			document.getElementById("divliste").style.display = 'block';
		}
		else if(y.id=="choix3")
		{
			if(x.id =="choix1")
			{
				$j(".blog").animate
				({
					width: 0,
					height:0
				});
				$j("#divhome").animate
				({
					width: 0,
					height:0
				});
				$j("#divmodif").animate
				({
					width: sousboxWidth ,
					height: sousboxHeight
				});
				$j(".blog").animate
				({
					width: boxWidth ,
					height:boxHeight
				});
				document.getElementById("divhome").style.display= 'none';
			}
			else if(x.id =="choix2")
			{
				$j(".blog").animate
				({
					width: 0,
					height:0
				});
				$j("#divliste").animate
				({
					width: 0,
					height:0
				});
				$j("#divmodif").animate
				({
					width: sousboxWidth ,
					height: sousboxHeight
				});
				$j(".blog").animate
				({
					width: boxWidth ,
					height:boxHeight
				});
				document.getElementById("divliste").style.display= 'none';
			}
			document.getElementById("divmodif").style.display = 'block';
		}
	else if(y.id == "choix1")
		{
				if(x.id =="choix2")
			{
				$j(".blog").animate
				({
					width: 0,
					height:0
				});
				$j("#divliste").animate
				({
					width: 0,
					height:0
				});
				$j("#divhome").animate
				({
					width: sousboxWidth ,
					height: sousboxHeight
				});
				$j(".blog").animate
				({
					width: boxWidth ,
					height:boxHeight
				});
				document.getElementById("divliste").style.display= 'none';
			}
			else if(x.id =="choix3")
			{
				$j(".blog").animate
				({
					width: 0,
					height:0
				});
				$j("#divmodif").animate
				({
					width: 0,
					height:0
				});
				$j("#divhome").animate
				({
					width: sousboxWidth ,
					height: sousboxHeight
				});
				$j(".blog").animate
				({
					width: boxWidth ,
					height:boxHeight
				});
				document.getElementById("divmodif").style.display= 'none';
			}
			document.getElementById("divhome").style.display = 'block';
		}
		
	x.classList.remove('selected');
	y.classList.add('selected');
	$j(y).fadeIn("slow");
}

var $j = jQuery.noConflict();

$j(document).ready(function()
{
	
});

function hide(myElement)
{
	document.getElementById(myElement).style.display = 'none';
}
