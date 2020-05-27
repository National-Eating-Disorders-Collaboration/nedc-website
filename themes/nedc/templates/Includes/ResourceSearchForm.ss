					<div class="search">
						<form $Form.AttributesHTML>
							<div class="flex">
								$Form.Fields.fieldByName(keywords)
								<button type="submit" class="btn darkBlue">Search</button>
							</div>
							<div class="flex">
								<ul>
									<span class="filter-action">Filter</span>
									<li>$Form.Fields.fieldByName(disorder)</li>
									<li>$Form.Fields.fieldByName(topic)</li>
									<li>$Form.Fields.fieldByName(article-type)</li>
									<li>$Form.Fields.fieldByName(timeframe)</li>
									<li class="hide">$Form.Fields.fieldByName(sort)</li>
								</ul>
								<div></div>
							</div>
						</form>
					</div>
