{foreach $data as $year}
<div id="tileBox" class="yearWrapper year{$year@key}">
	<div class="tile coral co2" id="" data-lapse="{$year.co2.lapse}">
		<p class="tile_title">{$year.co2.title}</p>
        <p class="tile_total">{$year.co2.value} kT CO2k</p> 
        <p class="tile_qty">100 tons every {$year.co2.lapse} seconds</p>
	</div>
	<div class="tile green military" id="">
        <p class="tile_title">{$year.military.title}</p>
        <p class="tile_total">{$year.military.value}</p> 
        <p class="tile_qty">USD$1,000 every {$year.military.lapse} seconds</p>
	</div>
	<div class="tile baby education" id="">
        <p class="tile_title">{$year.education.title}</p>
        <p class="tile_total">{$year.education.value}</p> 
        <p class="tile_qty">USD$1,000 every {$year.education.lapse} seconds</p>
	</div>
	<div class="tile orange population" id="">
        <p class="tile_title">{$year.population_growth.title}</p>
        <p class="tile_total">{$year.population_growth.value} people</p> 
        <p class="tile_qty">1 person every {$year.population_growth.lapse} seconds</p>
	</div>
	<div class="tile pink tourism" id="">
        <p class="tile_title">{$year.tourism.title}</p>
        <p class="tile_total">{$year.tourism.value} international tourists</p> 
        <p class="tile_qty">5 tourists every {$year.tourism.lapse} seconds</p>
	</div>
	<div class="tile yellow coal" id="">
        <p class="tile_title">{$year.coal_energy.title}</p>
        <p class="tile_total">{$year.coal_energy.value} kT CO2k</p> 
        <p class="tile_qty">100,000 kWh every {$year.coal_energy.lapse} seconds</p>
	</div>
	<div class="tile teal forests" id="teal">
        <p class="tile_title">{$year.forests_growth.title}</p>
        <p class="tile_total">{$year.military.value} kT CO2k</p> 
        <p class="tile_qty">500 m2 every {$year.forests_growth.lapse} seconds</p>
	</div>
</div>
{/foreach}
