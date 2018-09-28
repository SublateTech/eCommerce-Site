	<script type="text/javascript" src="ECOTree.js"></script>
		<link type="text/css" rel="stylesheet" href="ECOTree.css" />
		
		<style>v\:*{ behavior:url(#default#VML);}</style> 			
		<style>
			.copy {
				font-family : "Verdana";				
				font-size : 10px;
				color : #CCCCCC;
			}
		</style>

	<script>

			var t = null;
			
			function CreateTree() {
				t = new ECOTree('t','sample2');						
				t.config.iRootOrientation = ECOTree.RO_TOP;
				t.config.defaultNodeWidth = 140;
				t.config.defaultNodeHeight = 20;
				t.config.iSubtreeSeparation = 20;
				t.config.iSiblingSeparation = 10;										
				t.config.linkType = 'B';
				t.config.useTarget = false;
				t.config.nodeFill = ECOTree.NF_GRADIENT;
				t.config.colorStyle = ECOTree.CS_LEVEL;
				t.config.levelColors = ["#966E00","#BC9400","#D9B100","#FFD700"];
				t.config.levelBorderColors = ["#FFD700","#D9B100","#BC9400","#966E00"];
				t.config.nodeColor = "#FFD700";
				t.config.nodeBorderColor = "#FFD700";
				t.config.linkColor = "#FFD700";
				t.add(1,-1,'Home',null,null,"#F08080");
				t.add(2,1,'Brochures');
				t.add(3,1,'Fundr. Ideas');
				t.add(4,1,'Information');
				t.add(5,1,'Career Center');
				t.add(6,1,'Fun Zone');
				t.add(8,2,'Gift Avenue');
				t.add(8,2,'Cookie Dough');
				t.add(9,2,'Goose Berry patch');
				t.add(10,2,'Spring 07 Review');
				t.add(11,2,'Cheese Cakes');
				t.add(12,2,'Fall 06 Catalog');
				t.add(13,3,'Catalog/Brochure Info');
				t.add(14,3,'Cookie Dough info');
				t.add(15,3,'Holiday Ship Info');		
				t.add(16,3,'Dollar Bar Info');								
				t.add(17,4,'About US');
				t.add(18,4,'Contact US');
				t.add(19,4,'Total Service Program');		
				t.add(20,4,'Kick-Off Videos');								
				t.add(21,4,'Educational Assemblies');												
				t.add(22,4,'FAQ');
				t.add(23,5,'Territory Map');
				t.add(24,5,'Information Form');
				t.add(25,6,'Prize Programs');
				t.add(26,6,'Games');
				t.add(27,6,'Sig Secret');
				t.add(28,6,'Treasure Chest');
				
				t.UpdateTree();
			}					
			
		</script>
	
		<div id="sample2">
			<script>
				CreateTree();				
			</script>
		</div>
