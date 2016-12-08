// 						
// 						$dtSeries = wp_get_post_terms( $feature["ID"], 'series' );
// 						if ($dtSeries && !is_wp_error( $dtSeries )) { 
// 						
// 							// Default to Category Parent (if it exists)
// 							$howManyTerms = count($dtSeries); 
// 							$i = 0;
// 							
// 							if ($howManyTerms >= 2) {
// 								$i = $howManyTerms - 1;
// 								$dtSeries[0]->term_id = $dtSeries[$i]->term_id;
// 																		
// 							}
// 		
// 							$dtTitle = $dtSeries[$i]->name;
// 
// 						}
// 						
// 						if (!$dtTitle || $dtTitle == 'Reviews') {
// 							$title = $feature["post_title"];
// 						}
// 						
// 						else {
// 							$title = $dtTitle;
// 						}
// 				
// 						echo '<div class="post large-3 medium-6 end small-12 columns">
// 								<a class="dt-archive-thumb-small" href="' . get_the_permalink($feature["ID"]) . '">'  .
// 									get_the_post_thumbnail($feature["ID"], 'sm-archive') . 
// 									'<div class="dt-post-info">	
// 										<span style="font-weight:100;font-size:13px;"><span>' . date('F j', strtotime($feature["post_date"]) ) . '</span><br /><span class="dt-sh-title" style="font-size:18px;font-weight:700;">' . $title . '</span>
// 									</div>
// 								</a>
// 							 </div>';
