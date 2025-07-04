<body>

		<div class="body">
			<header id="header" class="header-effect-shrink" data-plugin-options="{'stickyEnabled': true, 'stickyEffect': 'shrink', 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': true, 'stickyChangeLogo': true, 'stickyStartAt': 30, 'stickyHeaderContainerHeight': 70}">
				<div class="header-body">
					<div class="header-container container">
						<div class="header-row">
							<div class="header-column">
								<div class="header-row">
									<div class="header-logo">
										<a href="<?= base_url('website')?>">
											<img alt="Porto" width="180" height="48" data-sticky-width="140" data-sticky-height="40" src="<?= base_url('assets/images/')?>1.jpeg">
										</a>
									</div>
								</div>
							</div>
							<div class="header-column justify-content-end">
								<div class="header-row">
									<div class="header-nav header-nav-line header-nav-top-line header-nav-top-line-with-border order-2 order-lg-1">
										<div class="header-nav-main header-nav-main-square header-nav-main-effect-2 header-nav-main-sub-effect-1">
											<nav class="collapse">
												<ul class="nav nav-pills" id="mainNav">
													<li class="dropdown">
														<a class="dropdown-item dropdown-toggle active" href="<?= base_url('website')?>">
															Home
														</a>
													</li>
													<li class="dropdown dropdown-mega">
														<a class="dropdown-item dropdown-toggle" href="<?= base_url('website/product')?>">
															Product
														</a>
													</li>
													<li class="dropdown dropdown-mega">
														<a class="dropdown-item dropdown-toggle" href="<?= base_url('website/penggunaan')?>">
															Account
														</a>
													</li>
													<!-- <li class="dropdown">
														<a class="dropdown-item dropdown-toggle" href="#">
															Features
														</a>
														<ul class="dropdown-menu">
															<li class="dropdown-submenu">
																<a class="dropdown-item" href="#">Headers</a>
																<ul class="dropdown-menu">
																	<li><a class="dropdown-item" href="feature-headers-overview.html">Overview</a></li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Classic</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="feature-headers-classic.html">Classic</a></li>
																			<li><a class="dropdown-item" href="feature-headers-classic-language-dropdown.html">Classic + Language Dropdown</a></li>
																			<li><a class="dropdown-item" href="feature-headers-classic-big-logo.html">Classic + Big Logo</a></li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Flat</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="feature-headers-flat.html">Flat</a></li>
																			<li><a class="dropdown-item" href="feature-headers-flat-top-bar.html">Flat + Top Bar</a></li>
																			<li><a class="dropdown-item" href="feature-headers-flat-top-bar-top-borders.html">Flat + Top Bar + Top Border</a></li>
																			<li><a class="dropdown-item" href="feature-headers-flat-colored-top-bar.html">Flat + Colored Top Bar</a></li>
																			<li><a class="dropdown-item" href="feature-headers-flat-borders.html">Flat + Borders</a></li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Center</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="feature-headers-center.html">Center</a></li>
																			<li><a class="dropdown-item" href="feature-headers-center-double-navs.html">Center + Double Navs</a></li>
																			<li><a class="dropdown-item" href="feature-headers-center-nav-buttons.html">Center + Nav + Buttons</a></li>
																			<li><a class="dropdown-item" href="feature-headers-center-below-slider.html">Center Below Slider</a></li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Floating</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="feature-headers-floating-bar.html">Floating Bar</a></li>
																			<li><a class="dropdown-item" href="feature-headers-floating-icons.html">Floating Icons</a></li>
																		</ul>
																	</li>
																	<li><a class="dropdown-item" href="feature-headers-below-slider.html">Below Slider</a></li>
																	<li><a class="dropdown-item" href="feature-headers-full-video.html">Full Video</a></li>
																	<li><a class="dropdown-item" href="feature-headers-narrow.html">Narrow</a></li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Sticky</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="feature-headers-sticky-shrink.html">Sticky Shrink</a></li>
																			<li><a class="dropdown-item" href="feature-headers-sticky-static.html">Sticky Static</a></li>
																			<li><a class="dropdown-item" href="feature-headers-sticky-change-logo.html">Sticky Change Logo</a></li>
																			<li><a class="dropdown-item" href="feature-headers-sticky-reveal.html">Sticky Reveal</a></li>
																		</ul>
																	</li>				
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Transparent</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="feature-headers-transparent-light.html">Transparent Light</a></li>
																			<li><a class="dropdown-item" href="feature-headers-transparent-dark.html">Transparent Dark</a></li>
																			<li><a class="dropdown-item" href="feature-headers-transparent-light-bottom-border.html">Transparent Light + Bottom Border</a></li>
																			<li><a class="dropdown-item" href="feature-headers-transparent-dark-bottom-border.html">Transparent Dark + Bottom Border</a></li>
																			<li><a class="dropdown-item" href="feature-headers-transparent-bottom-slider.html">Transparent Bottom Slider</a></li>
																			<li><a class="dropdown-item" href="feature-headers-semi-transparent-light.html">Semi Transparent Light</a></li>
																			<li><a class="dropdown-item" href="feature-headers-semi-transparent-dark.html">Semi Transparent Dark</a></li>
																			<li><a class="dropdown-item" href="feature-headers-semi-transparent-bottom-slider.html">Semi Transparent Bottom Slider</a></li>
																			<li><a class="dropdown-item" href="feature-headers-semi-transparent-top-bar-borders.html">Semi Transparent + Top Bar + Borders</a></li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Full Width</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="feature-headers-full-width.html">Full Width</a></li>
																			<li><a class="dropdown-item" href="feature-headers-full-width-borders.html">Full Width + Borders</a></li>
																			<li><a class="dropdown-item" href="feature-headers-full-width-transparent-light.html">Full Width Transparent Light</a></li>
																			<li><a class="dropdown-item" href="feature-headers-full-width-transparent-dark.html">Full Width Transparent Dark</a></li>
																			<li><a class="dropdown-item" href="feature-headers-full-width-semi-transparent-light.html">Full Width Semi Transparent Light</a></li>
																			<li><a class="dropdown-item" href="feature-headers-full-width-semi-transparent-dark.html">Full Width Semi Transparent Dark</a></li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Navbar</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="feature-headers-navbar.html">Navbar</a></li>
																			<li><a class="dropdown-item" href="feature-headers-navbar-full.html">Navbar Full</a></li>
																			<li><a class="dropdown-item" href="feature-headers-navbar-pills.html">Navbar Pills</a></li>
																			<li><a class="dropdown-item" href="feature-headers-navbar-divisors.html">Navbar Divisors</a></li>
																			<li><a class="dropdown-item" href="feature-headers-navbar-icons-search.html">Nav Bar + Icons + Search</a></li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Side Header</a>
																		<ul class="dropdown-menu">
																			<li class="dropdown-submenu">
																				<a class="dropdown-item" href="#">Side Header Left</a>
																				<ul class="dropdown-menu">
																					<li><a class="dropdown-item" href="feature-headers-side-header-left-dropdown.html">Dropdown</a></li>
																					<li><a class="dropdown-item" href="feature-headers-side-header-left-expand.html">Expand</a></li>
																					<li><a class="dropdown-item" href="feature-headers-side-header-left-columns.html">Columns</a></li>
																					<li><a class="dropdown-item" href="feature-headers-side-header-left-slide.html">Slide</a></li>
																					<li><a class="dropdown-item" href="feature-headers-side-header-left-semi-transparent.html">Semi Transparent</a></li>
																					<li><a class="dropdown-item" href="feature-headers-side-header-left-dark.html">Dark</a></li>
																				</ul>
																			</li>
																			<li class="dropdown-submenu">
																				<a class="dropdown-item" href="#">Side Header Right</a>
																				<ul class="dropdown-menu">
																					<li><a class="dropdown-item" href="feature-headers-side-header-right-dropdown.html">Dropdown</a></li>
																					<li><a class="dropdown-item" href="feature-headers-side-header-right-expand.html">Expand</a></li>
																					<li><a class="dropdown-item" href="feature-headers-side-header-right-columns.html">Columns</a></li>
																					<li><a class="dropdown-item" href="feature-headers-side-header-right-slide.html">Slide</a></li>
																					<li><a class="dropdown-item" href="feature-headers-side-header-right-semi-transparent.html">Semi Transparent</a></li>
																					<li><a class="dropdown-item" href="feature-headers-side-header-right-dark.html">Dark</a></li>
																				</ul>
																			</li>
																			<li class="dropdown-submenu">
																				<a class="dropdown-item" href="#">Side Header Offcanvas</a>
																				<ul class="dropdown-menu">
																					<li><a class="dropdown-item" href="feature-headers-side-header-offcanvas-push.html">Push</a></li>
																					<li><a class="dropdown-item" href="feature-headers-side-header-offcanvas-slide.html">Slide</a></li>
																				</ul>
																			</li>
																			<li><a class="dropdown-item" href="feature-headers-side-header-narrow-bar.html">Side Header Narrow Bar</a></li>
																		</ul>
																	</li>
																	<li><a class="dropdown-item" href="feature-headers-sign-in-sign-up.html">Sign In / Sign Up</a></li>
																	<li><a class="dropdown-item" href="feature-headers-logged.html">Logged</a></li>
																	<li><a class="dropdown-item" href="feature-headers-mini-cart.html">Mini Cart</a></li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Search Styles</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="feature-headers-search-simple-input.html">Simple Input</a></li>
																			<li><a class="dropdown-item" href="feature-headers-search-simple-input-reveal.html">Simple Input Reveal</a></li>
																			<li><a class="dropdown-item" href="feature-headers-search-dropdown.html">Dropdown</a></li>
																			<li><a class="dropdown-item" href="feature-headers-search-big-input-hidden.html">Big Input Hidden</a></li>
																			<li><a class="dropdown-item" href="feature-headers-search-full-screen.html">Full Screen</a></li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Extra</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="feature-headers-extra-big-icon.html">Big Icon</a></li>
																			<li><a class="dropdown-item" href="feature-headers-extra-big-icons-top.html">Big Icons Top</a></li>
																			<li><a class="dropdown-item" href="feature-headers-extra-button.html">Button</a></li>
																			<li><a class="dropdown-item" href="feature-headers-extra-background-color.html">Background Color</a></li>
																		</ul>
																	</li>
																</ul>
															</li>
															<li class="dropdown-submenu">
																<a class="dropdown-item" href="#">Navigations</a>
																<ul class="dropdown-menu">
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Pills</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="feature-navigations-pills.html">Pills</a></li>
																			<li><a class="dropdown-item" href="feature-navigations-pills-arrows.html">Pills + Arrows</a></li>
																			<li><a class="dropdown-item" href="feature-navigations-pills-dark-text.html">Pills Dark Text</a></li>
																			<li><a class="dropdown-item" href="feature-navigations-pills-color-dropdown.html">Pills Color Dropdown</a></li>
																			<li><a class="dropdown-item" href="feature-navigations-pills-square.html">Pills Square</a></li>
																			<li><a class="dropdown-item" href="feature-navigations-pills-rounded.html">Pills Rounded</a></li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Stripes</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="feature-navigations-stripe.html">Stripe</a></li>
																			<li><a class="dropdown-item" href="feature-navigations-stripe-dark-text.html">Stripe Dark Text</a></li>
																			<li><a class="dropdown-item" href="feature-navigations-stripe-color-dropdown.html">Stripe Color Dropdown</a></li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Hover Effects</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="feature-navigations-hover-top-line.html">Top Line</a></li>
																			<li><a class="dropdown-item" href="feature-navigations-hover-top-line-animated.html">Top Line Animated</a></li>
																			<li><a class="dropdown-item" href="feature-navigations-hover-top-line-color-dropdown.html">Top Line Color Dropdown</a></li>
																			<li><a class="dropdown-item" href="feature-navigations-hover-bottom-line.html">Bottom Line</a></li>
																			<li><a class="dropdown-item" href="feature-navigations-hover-bottom-line-animated.html">Bottom Line Animated</a></li>
																			<li><a class="dropdown-item" href="feature-navigations-hover-slide.html">Slide</a></li>
																			<li><a class="dropdown-item" href="feature-navigations-hover-sub-title.html">Sub Title</a></li>
																			<li><a class="dropdown-item" href="feature-navigations-hover-line-under-text.html">Line Under Text</a></li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Vertical</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="feature-navigations-vertical-dropdown.html">Dropdown</a></li>
																			<li><a class="dropdown-item" href="feature-navigations-vertical-expand.html">Expand</a></li>
																			<li><a class="dropdown-item" href="feature-navigations-vertical-columns.html">Columns</a></li>
																			<li><a class="dropdown-item" href="feature-navigations-vertical-slide.html">Slide</a></li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Hamburguer</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="feature-navigations-hamburguer-sidebar.html">Sidebar</a></li>
																			<li><a class="dropdown-item" href="feature-navigations-hamburguer-overlay.html">Overlay</a></li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Dropdown Styles</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="feature-navigations-dropdowns-dark.html">Dark</a></li>
																			<li><a class="dropdown-item" href="feature-navigations-dropdowns-light.html">Light</a></li>
																			<li><a class="dropdown-item" href="feature-navigations-dropdowns-colors.html">Colors</a></li>
																			<li><a class="dropdown-item" href="feature-navigations-dropdowns-top-line.html">Top Line</a></li>
																			<li><a class="dropdown-item" href="feature-navigations-dropdowns-square.html">Square</a></li>
																			<li><a class="dropdown-item" href="feature-navigations-dropdowns-arrow.html">Arrow Dropdown</a></li>
																			<li><a class="dropdown-item" href="feature-navigations-dropdowns-arrow-center.html">Arrow Center Dropdown</a></li>
																			<li><a class="dropdown-item" href="feature-navigations-dropdowns-modern-light.html">Modern Light</a></li>
																			<li><a class="dropdown-item" href="feature-navigations-dropdowns-modern-dark.html">Modern Dark</a></li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Dropdown Effects</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="feature-navigations-dropdowns-effect-no-effect.html">No Effect</a></li>
																			<li><a class="dropdown-item" href="feature-navigations-dropdowns-effect-opacity.html">Opacity</a></li>
																			<li><a class="dropdown-item" href="feature-navigations-dropdowns-effect-move-to-top.html">Move To Top</a></li>
																			<li><a class="dropdown-item" href="feature-navigations-dropdowns-effect-move-to-bottom.html">Move To Bottom</a></li>
																			<li><a class="dropdown-item" href="feature-navigations-dropdowns-effect-move-to-right.html">Move To Right</a></li>
																			<li><a class="dropdown-item" href="feature-navigations-dropdowns-effect-move-to-left.html">Move To Left</a></li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Font Styles</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="feature-navigations-font-small.html">Small</a></li>
																			<li><a class="dropdown-item" href="feature-navigations-font-medium.html">Medium</a></li>
																			<li><a class="dropdown-item" href="feature-navigations-font-large.html">Large</a></li>
																			<li><a class="dropdown-item" href="feature-navigations-font-alternative.html">Alternative</a></li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Icons</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="feature-navigations-icons.html">Icons</a></li>
																			<li><a class="dropdown-item" href="feature-navigations-icons-float-icons.html">Float Icons</a></li>
																		</ul>
																	</li>
																	<li><a class="dropdown-item" href="feature-navigations-sub-title.html">Sub Title</a></li>
																	<li><a class="dropdown-item" href="feature-navigations-divisors.html">Divisors</a></li>
																	<li><a class="dropdown-item" href="feature-navigations-logo-between.html">Logo Between</a></li>
																	<li><a class="dropdown-item" href="feature-navigations-one-page.html">One Page Nav</a></li>
																	<li><a class="dropdown-item" href="feature-navigations-click-to-open.html">Click To Open</a></li>
																</ul>
															</li>
															<li class="dropdown-submenu">
																<a class="dropdown-item" href="#">Page Headers</a>
																<ul class="dropdown-menu">
																	<li><a class="dropdown-item" href="feature-page-headers-overview.html">Overview</a></li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Classic</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="feature-page-headers-classic-small.html">Small</a></li>				
																			<li><a class="dropdown-item" href="feature-page-headers-classic-medium.html">Medium</a></li>				
																			<li><a class="dropdown-item" href="feature-page-headers-classic-large.html">Large</a></li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Modern</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="feature-page-headers-modern-small.html">Small</a></li>				
																			<li><a class="dropdown-item" href="feature-page-headers-modern-medium.html">Medium</a></li>				
																			<li><a class="dropdown-item" href="feature-page-headers-modern-large.html">Large</a></li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Colors</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="feature-page-headers-colors-primary.html">Primary</a></li>				
																			<li><a class="dropdown-item" href="feature-page-headers-colors-secondary.html">Secondary</a></li>				
																			<li><a class="dropdown-item" href="feature-page-headers-colors-tertiary.html">Tertiary</a></li>				
																			<li><a class="dropdown-item" href="feature-page-headers-colors-quaternary.html">Quaternary</a></li>				
																			<li><a class="dropdown-item" href="feature-page-headers-colors-light.html">Light</a></li>				
																			<li><a class="dropdown-item" href="feature-page-headers-colors-dark.html">Dark</a></li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Title Position</a>
																		<ul class="dropdown-menu">
																			<li class="dropdown-submenu">
																				<a class="dropdown-item" href="#">Left</a>
																				<ul class="dropdown-menu">
																					<li><a class="dropdown-item" href="feature-page-headers-title-position-left-small.html">Small</a></li>				
																					<li><a class="dropdown-item" href="feature-page-headers-title-position-left-medium.html">Medium</a></li>				
																					<li><a class="dropdown-item" href="feature-page-headers-title-position-left-large.html">Large</a></li>
																				</ul>
																			</li>
																			<li class="dropdown-submenu">
																				<a class="dropdown-item" href="#">Right</a>
																				<ul class="dropdown-menu">
																					<li><a class="dropdown-item" href="feature-page-headers-title-position-right-small.html">Small</a></li>				
																					<li><a class="dropdown-item" href="feature-page-headers-title-position-right-medium.html">Medium</a></li>				
																					<li><a class="dropdown-item" href="feature-page-headers-title-position-right-large.html">Large</a></li>
																				</ul>
																			</li>
																			<li class="dropdown-submenu">
																				<a class="dropdown-item" href="#">Center</a>
																				<ul class="dropdown-menu">
																					<li><a class="dropdown-item" href="feature-page-headers-title-position-center-small.html">Small</a></li>				
																					<li><a class="dropdown-item" href="feature-page-headers-title-position-center-medium.html">Medium</a></li>				
																					<li><a class="dropdown-item" href="feature-page-headers-title-position-center-large.html">Large</a></li>
																				</ul>
																			</li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Background</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="feature-page-headers-background-fixed.html">Fixed</a></li>		
																			<li><a class="dropdown-item" href="feature-page-headers-background-parallax.html">Parallax</a></li>
																			<li><a class="dropdown-item" href="feature-page-headers-background-video.html">Video</a></li>			
																			<li><a class="dropdown-item" href="feature-page-headers-background-transparent-header.html">Transparent Header</a></li>			
																			<li><a class="dropdown-item" href="feature-page-headers-background-pattern.html">Pattern</a></li>			
																			<li><a class="dropdown-item" href="feature-page-headers-background-overlay.html">Overlay</a></li>			
																			<li><a class="dropdown-item" href="feature-page-headers-background-clean.html">Clean (No Background)</a></li>	
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Extra</a>
																		<ul class="dropdown-menu">
																			<li class="dropdown-submenu">
																				<a class="dropdown-item" href="#">Breadcrumb</a>
																				<ul class="dropdown-menu">
																					<li><a class="dropdown-item" href="feature-page-headers-extra-breadcrumb-outside.html">Outside</a></li>				
																					<li><a class="dropdown-item" href="feature-page-headers-extra-breadcrumb-dark.html">Dark</a></li>			
																				</ul>
																			</li>
																			<li><a class="dropdown-item" href="feature-page-headers-extra-scroll-to-content.html">Scroll to Content</a></li>			
																			<li><a class="dropdown-item" href="feature-page-headers-extra-full-width.html">Full Width</a></li>
																		</ul>
																	</li>
																</ul>
															</li>
															<li class="dropdown-submenu">
																<a class="dropdown-item" href="#">Footers</a>
																<ul class="dropdown-menu">
																	<li><a class="dropdown-item" href="feature-footers-overview.html">Overview</a></li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Classic</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="feature-footers-classic.html#footer">Classic</a></li>
																			<li><a class="dropdown-item" href="feature-footers-classic-advanced.html#footer">Advanced</a></li>
																			<li><a class="dropdown-item" href="feature-footers-classic-compact.html#footer">Compact</a></li>
																			<li><a class="dropdown-item" href="feature-footers-classic-simple.html#footer">Simple</a></li>
																			<li><a class="dropdown-item" href="feature-footers-classic-locations.html#footer">Locations</a></li>
																			<li class="dropdown-submenu">
																				<a class="dropdown-item" href="#">Copyright</a>
																				<ul class="dropdown-menu">
																					<li><a class="dropdown-item" href="feature-footers-classic-copyright-light.html#footer">Light</a></li>
																					<li><a class="dropdown-item" href="feature-footers-classic-copyright-dark.html#footer">Dark</a></li>
																					<li><a class="dropdown-item" href="feature-footers-classic-copyright-social-icons.html#footer">Social Icons</a></li>
																				</ul>
																			</li>
																			<li class="dropdown-submenu">
																				<a class="dropdown-item" href="#">Colors</a>
																				<ul class="dropdown-menu">
																					<li><a class="dropdown-item" href="feature-footers-classic-colors-primary.html#footer">Primary</a></li>
																					<li><a class="dropdown-item" href="feature-footers-classic-colors-secondary.html#footer">Secondary</a></li>
																					<li><a class="dropdown-item" href="feature-footers-classic-colors-tertiary.html#footer">Tertiary</a></li>
																					<li><a class="dropdown-item" href="feature-footers-classic-colors-quaternary.html#footer			">Quaternary</a></li>
																					<li><a class="dropdown-item" href="feature-footers-classic-colors-light.html#footer">Light</a></li>
																					<li><a class="dropdown-item" href="feature-footers-classic-colors-light-simple.html#footer">Light Simple</a></li>
																				</ul>
																			</li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Modern</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="feature-footers-modern.html#footer">Modern</a></li>
																			<li><a class="dropdown-item" href="feature-footers-modern-font-style-alternative.html#footer">Font Style Alternative</a></li>
																			<li><a class="dropdown-item" href="feature-footers-modern-clean.html#footer">Clean</a></li>	
																			<li><a class="dropdown-item" href="feature-footers-modern-useful-links.html#footer">Useful Links</a></li>
																			<li class="dropdown-submenu">
																				<a class="dropdown-item" href="#">Background</a>
																				<ul class="dropdown-menu">
																					<li><a class="dropdown-item" href="feature-footers-modern-background-image-simple.html#footer">Image Simple</a></li>
																					<li><a class="dropdown-item" href="feature-footers-modern-background-image-advanced.html#footer">Image Advanced</a></li>
																					<li><a class="dropdown-item" href="feature-footers-modern-background-video-simple.html#footer">Video Simple</a></li>
																				</ul>
																			</li>
																			<li class="dropdown-submenu">
																				<a class="dropdown-item" href="#">Call to Action</a>
																				<ul class="dropdown-menu">
																					<li><a class="dropdown-item" href="feature-footers-modern-call-to-action-button.html#footer">Button</a></li>
																					<li><a class="dropdown-item" href="feature-footers-modern-call-to-action-simple.html#footer">Simple</a></li>
																				</ul>
																			</li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Blog</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="feature-footers-blog-classic.html#footer">Blog Classic</a></li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">eCommerce</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="feature-footers-ecommerce-classic.html#footer">eCommerce Classic</a></li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Contact Form</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="feature-footers-contact-form-classic.html#footer">Classic</a></li>
																			<li><a class="dropdown-item" href="feature-footers-contact-form-above-the-map.html#footer">Above the Map</a></li>
																			<li><a class="dropdown-item" href="feature-footers-contact-form-center.html#footer">Center</a></li>
																			<li><a class="dropdown-item" href="feature-footers-contact-form-columns.html#footer">Columns</a></li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Map</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="feature-footers-map-hidden.html#footer">Hidden Map</a></li> 
																			<li><a class="dropdown-item" href="feature-footers-map-full-width.html#footer">Full Width</a></li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Extra</a>
																		<ul class="dropdown-menu">
																			<li class="dropdown-submenu">
																				<a class="dropdown-item" href="#">Simple</a>
																				<ul class="dropdown-menu">
																					<li><a class="dropdown-item" href="feature-footers-extra-top-social-icons.html#footer">Top Social Icons</a></li>
																					<li><a class="dropdown-item" href="feature-footers-extra-big-icons.html#footer">Big Icons</a></li>
																				</ul>
																			</li>
																			<li><a class="dropdown-item" href="feature-footers-extra-recent-work.html#footer">Recent Work</a></li>
																			<li><a class="dropdown-item" href="feature-footers-extra-reveal.html#footer">Reveal</a></li>
																			<li><a class="dropdown-item" href="feature-footers-extra-instagram.html#footer">Instagram</a></li>
																			<li class="dropdown-submenu">
																				<a class="dropdown-item" href="#">Full Width</a>
																				<ul class="dropdown-menu">
																					<li><a class="dropdown-item" href="feature-footers-extra-full-width-light.html#footer">Simple Light</a></li>
																					<li><a class="dropdown-item" href="feature-footers-extra-full-width-dark.html#footer">Simple Dark</a></li>
																				</ul>
																			</li>
																		</ul>
																	</li>
																</ul>
															</li>
															<li class="dropdown-submenu">
																<a class="dropdown-item" href="#">Admin Extension <span class="tip tip-dark">hot</span><em class="not-included">(Not Included)</em></a>
																<ul class="dropdown-menu">
																	<li><a class="dropdown-item" href="feature-admin-forms-basic.html">Forms Basic</a></li>
																	<li><a class="dropdown-item" href="feature-admin-forms-advanced.html">Forms Advanced</a></li>
																	<li><a class="dropdown-item" href="feature-admin-forms-wizard.html">Forms Wizard</a></li>
																	<li><a class="dropdown-item" href="feature-admin-forms-code-editor.html">Code Editor</a></li>
																	<li><a class="dropdown-item" href="feature-admin-tables-advanced.html">Tables Advanced</a></li>
																	<li><a class="dropdown-item" href="feature-admin-tables-responsive.html">Tables Responsive</a></li>
																	<li><a class="dropdown-item" href="feature-admin-tables-editable.html">Tables Editable</a></li>
																	<li><a class="dropdown-item" href="feature-admin-tables-ajax.html">Tables Ajax</a></li>
																	<li><a class="dropdown-item" href="feature-admin-charts.html">Charts</a></li>
																</ul>
															</li>
															<li class="dropdown-submenu">
																<a class="dropdown-item" href="#">Sliders</a>
																<ul class="dropdown-menu">
																	<li><a class="dropdown-item" href="index-classic.html">Revolution Slider</a></li>
																	<li><a class="dropdown-item" href="index-slider-nivo.html">Nivo Slider</a></li>
																</ul>
															</li>
															<li class="dropdown-submenu">
																<a class="dropdown-item" href="#">Layout Options</a>
																<ul class="dropdown-menu">
																	<li><a class="dropdown-item" href="feature-layout-boxed.html">Boxed</a></li>
																	<li><a class="dropdown-item" href="feature-layout-dark.html">Dark</a></li>
																	<li><a class="dropdown-item" href="feature-layout-rtl.html">RTL</a></li>
																</ul>
															</li>
															<li class="dropdown-submenu">
																<a class="dropdown-item" href="#">Extra</a>
																<ul class="dropdown-menu">
																	<li><a class="dropdown-item" href="feature-grid-system.html">Grid System</a></li>
																	<li><a class="dropdown-item" href="feature-page-loading.html">Page Loading</a></li>
																	<li><a class="dropdown-item" href="feature-page-transition.html">Page Transition</a></li>
																	<li><a class="dropdown-item" href="feature-lazy-load.html">Lazy Load</a></li>
																	<li><a class="dropdown-item" href="feature-side-panel.html">Side Panel</a></li>
																</ul>
															</li>
														</ul>
													</li>
													<li class="dropdown">
														<a class="dropdown-item dropdown-toggle" href="#">
															Pages
														</a>
														<ul class="dropdown-menu">
															<li class="dropdown-submenu">
																<a class="dropdown-item" href="#">Contact Us</a>
																<ul class="dropdown-menu">
																	<li><a class="dropdown-item" href="contact-us-advanced.php">Contact Us - Advanced</a></li>
																	<li><a class="dropdown-item" href="contact-us.html">Contact Us - Basic</a></li>
																	<li><a class="dropdown-item" href="contact-us-recaptcha.html">Contact Us - Recaptcha</a></li>
																</ul>
															</li>
															<li class="dropdown-submenu">
																<a class="dropdown-item" href="#">About Us</a>
																<ul class="dropdown-menu">
																	<li><a class="dropdown-item" href="about-us-advanced.html">About Us - Advanced</a></li>
																	<li><a class="dropdown-item" href="about-us.html">About Us - Basic</a></li>
																	<li><a class="dropdown-item" href="about-me.html">About Me</a></li>
																</ul>
															</li>
															<li class="dropdown-submenu">
																<a class="dropdown-item" href="#">Layouts</a>
																<ul class="dropdown-menu">
																	<li><a class="dropdown-item" href="page-full-width.html">Full Width</a></li>
																	<li><a class="dropdown-item" href="page-left-sidebar.html">Left Sidebar</a></li>
																	<li><a class="dropdown-item" href="page-right-sidebar.html">Right Sidebar</a></li>
																	<li><a class="dropdown-item" href="page-left-and-right-sidebars.html">Left and Right Sidebars</a></li>
																	<li><a class="dropdown-item" href="page-sticky-sidebar.html">Sticky Sidebar</a></li>
																	<li><a class="dropdown-item" href="page-secondary-navbar.html">Secondary Navbar</a></li>
																</ul>
															</li>
															<li class="dropdown-submenu">
																<a class="dropdown-item" href="#">Extra</a>
																<ul class="dropdown-menu">
																	<li><a class="dropdown-item" href="page-404.html">404 Error</a></li>
																	<li><a class="dropdown-item" href="page-500.html">500 Error</a></li>
																	<li><a class="dropdown-item" href="page-coming-soon.html">Coming Soon</a></li>
																	<li><a class="dropdown-item" href="page-maintenance-mode.html">Maintenance Mode</a></li>
																	<li><a class="dropdown-item" href="page-search-results.html">Search Results</a></li>
																	<li><a class="dropdown-item" href="sitemap.html">Sitemap</a></li>
																</ul>
															</li>
															<li class="dropdown-submenu">
																<a class="dropdown-item" href="#">Team</a>
																<ul class="dropdown-menu">
																	<li><a class="dropdown-item" href="page-team-advanced.html">Team - Advanced</a></li>
																	<li><a class="dropdown-item" href="page-team.html">Team - Basic</a></li>
																</ul>
															</li>
															<li class="dropdown-submenu">
																<a class="dropdown-item" href="#">Services</a>
																<ul class="dropdown-menu">
																	<li><a class="dropdown-item" href="page-services.html">Services - Version 1</a></li>
																	<li><a class="dropdown-item" href="page-services-2.html">Services - Version 2</a></li>
																	<li><a class="dropdown-item" href="page-services-3.html">Services - Version 3</a></li>
																</ul>
															</li>
															<li><a class="dropdown-item" href="page-custom-header.html">Custom Header</a></li>
															<li><a class="dropdown-item" href="page-careers.html">Careers</a></li>
															<li><a class="dropdown-item" href="page-faq.html">FAQ</a></li>
															<li><a class="dropdown-item" href="page-login.html">Login / Register</a></li>
															<li><a class="dropdown-item" href="page-user-profile.html">User Profile</a></li>
														</ul>
													</li>
													<li class="dropdown">
														<a class="dropdown-item dropdown-toggle" href="#">
															Portfolio
														</a>
														<ul class="dropdown-menu">
															<li class="dropdown-submenu">
																<a class="dropdown-item" href="#">Single Project</a>
																<ul class="dropdown-menu">
																	<li><a class="dropdown-item" href="portfolio-single-wide-slider.html">Wide Slider</a></li>
																	<li><a class="dropdown-item" href="portfolio-single-small-slider.html">Small Slider</a></li>
																	<li><a class="dropdown-item" href="portfolio-single-full-width-slider.html">Full Width Slider</a></li>
																	<li><a class="dropdown-item" href="portfolio-single-gallery.html">Gallery</a></li>
																	<li><a class="dropdown-item" href="portfolio-single-carousel.html">Carousel</a></li>
																	<li><a class="dropdown-item" href="portfolio-single-medias.html">Medias</a></li>
																	<li><a class="dropdown-item" href="portfolio-single-full-width-video.html">Full Width Video</a></li>
																	<li><a class="dropdown-item" href="portfolio-single-masonry-images.html">Masonry Images</a></li>
																	<li><a class="dropdown-item" href="portfolio-single-left-sidebar.html">Left Sidebar</a></li>
																	<li><a class="dropdown-item" href="portfolio-single-right-sidebar.html">Right Sidebar</a></li>
																	<li><a class="dropdown-item" href="portfolio-single-left-and-right-sidebars.html">Left and Right Sidebars</a></li>
																	<li><a class="dropdown-item" href="portfolio-single-sticky-sidebar.html">Sticky Sidebar</a></li>
																	<li><a class="dropdown-item" href="portfolio-single-extended.html">Extended</a></li>
																</ul>
															</li>
															<li class="dropdown-submenu">
																<a class="dropdown-item" href="#">Grid Layouts</a>
																<ul class="dropdown-menu">
																	<li><a class="dropdown-item" href="portfolio-grid-1-column.html">1 Column</a></li>
																	<li><a class="dropdown-item" href="portfolio-grid-2-columns.html">2 Columns</a></li>
																	<li><a class="dropdown-item" href="portfolio-grid-3-columns.html">3 Columns</a></li>
																	<li><a class="dropdown-item" href="portfolio-grid-4-columns.html">4 Columns</a></li>
																	<li><a class="dropdown-item" href="portfolio-grid-5-columns.html">5 Columns</a></li>
																	<li><a class="dropdown-item" href="portfolio-grid-6-columns.html">6 Columns</a></li>
																	<li><a class="dropdown-item" href="portfolio-grid-no-margins.html">No Margins</a></li>
																	<li><a class="dropdown-item" href="portfolio-grid-full-width.html">Full Width</a></li>
																	<li><a class="dropdown-item" href="portfolio-grid-full-width-no-margins.html">Full Width No Margins</a></li>
																	<li><a class="dropdown-item" href="portfolio-grid-1-column-title-and-description.html">Title and Description</a></li>
																</ul>
															</li>
															<li class="dropdown-submenu">
																<a class="dropdown-item" href="#">Masonry Layouts</a>
																<ul class="dropdown-menu">
																	<li><a class="dropdown-item" href="portfolio-masonry-2-columns.html">2 Columns</a></li>
																	<li><a class="dropdown-item" href="portfolio-masonry-3-columns.html">3 Columns</a></li>
																	<li><a class="dropdown-item" href="portfolio-masonry-4-columns.html">4 Columns</a></li>
																	<li><a class="dropdown-item" href="portfolio-masonry-5-columns.html">5 Columns</a></li>
																	<li><a class="dropdown-item" href="portfolio-masonry-6-columns.html">6 Columns</a></li>
																	<li><a class="dropdown-item" href="portfolio-masonry-no-margins.html">No Margins</a></li>
																	<li><a class="dropdown-item" href="portfolio-masonry-full-width.html">Full Width</a></li>
																</ul>
															</li>
															<li class="dropdown-submenu">
																<a class="dropdown-item" href="#">Sidebar Layouts</a>
																<ul class="dropdown-menu">
																	<li><a class="dropdown-item" href="portfolio-sidebar-left.html">Left Sidebar</a></li>
																	<li><a class="dropdown-item" href="portfolio-sidebar-right.html">Right Sidebar</a></li>
																	<li><a class="dropdown-item" href="portfolio-sidebar-left-and-right.html">Left and Right Sidebars</a></li>
																	<li><a class="dropdown-item" href="portfolio-sidebar-sticky.html">Sticky Sidebar</a></li>
																</ul>
															</li>
															<li class="dropdown-submenu">
																<a class="dropdown-item" href="#">Ajax</a>
																<ul class="dropdown-menu">
																	<li><a class="dropdown-item" href="portfolio-ajax-page.html">Ajax on Page</a></li>
																	<li><a class="dropdown-item" href="portfolio-ajax-modal.html">Ajax on Modal</a></li>
																</ul>
															</li>
															<li class="dropdown-submenu">
																<a class="dropdown-item" href="#">Extra</a>
																<ul class="dropdown-menu">
																	<li><a class="dropdown-item" href="portfolio-extra-timeline.html">Timeline</a></li>
																	<li><a class="dropdown-item" href="portfolio-extra-lightbox.html">Lightbox</a></li>
																	<li><a class="dropdown-item" href="portfolio-extra-load-more.html">Load More</a></li>
																	<li><a class="dropdown-item" href="portfolio-extra-infinite-scroll.html">Infinite Scroll</a></li>
																	<li><a class="dropdown-item" href="portfolio-extra-pagination.html">Pagination</a></li>
																	<li><a class="dropdown-item" href="portfolio-extra-combination-filters.html">Combination Filters</a></li>
																</ul>
															</li>
														</ul>
													</li>
													<li class="dropdown">
														<a class="dropdown-item dropdown-toggle" href="#">
															Blog
														</a>
														<ul class="dropdown-menu">
															<li class="dropdown-submenu">
																<a class="dropdown-item" href="#">Large Image</a>
																<ul class="dropdown-menu">
																	<li><a class="dropdown-item" href="blog-large-image-full-width.html">Full Width</a></li>
																	<li><a class="dropdown-item" href="blog-large-image-sidebar-left.html">Left Sidebar</a></li>
																	<li><a class="dropdown-item" href="blog-large-image-sidebar-right.html">Right Sidebar </a></li>
																	<li><a class="dropdown-item" href="blog-large-image-sidebar-left-and-right.html">Left and Right Sidebar</a></li>
																</ul>
															</li>
															<li class="dropdown-submenu">
																<a class="dropdown-item" href="#">Medium Image</a>
																<ul class="dropdown-menu">
																	<li><a class="dropdown-item" href="blog-medium-image-sidebar-left.html">Left Sidebar</a></li>
																	<li><a class="dropdown-item" href="blog-medium-image-sidebar-right.html">Right Sidebar </a></li>
																</ul>
															</li>
															<li class="dropdown-submenu">
																<a class="dropdown-item" href="#">Grid</a>
																<ul class="dropdown-menu">
																	<li><a class="dropdown-item" href="blog-grid-4-columns.html">4 Columns</a></li>
																	<li><a class="dropdown-item" href="blog-grid-3-columns.html">3 Columns</a></li>
																	<li><a class="dropdown-item" href="blog-grid-full-width.html">Full Width</a></li>
																	<li><a class="dropdown-item" href="blog-grid-no-margins.html">No Margins</a></li>
																	<li><a class="dropdown-item" href="blog-grid-no-margins-full-width.html">No Margins Full Width</a></li>
																	<li><a class="dropdown-item" href="blog-grid-sidebar-left.html">Left Sidebar</a></li>
																	<li><a class="dropdown-item" href="blog-grid-sidebar-right.html">Right Sidebar </a></li>
																	<li><a class="dropdown-item" href="blog-grid-sidebar-left-and-right.html">Left and Right Sidebar</a></li>
																</ul>
															</li>
															<li class="dropdown-submenu">
																<a class="dropdown-item" href="#">Masonry</a>
																<ul class="dropdown-menu">
																	<li><a class="dropdown-item" href="blog-masonry-4-columns.html">4 Columns</a></li>
																	<li><a class="dropdown-item" href="blog-masonry-3-columns.html">3 Columns</a></li>
																	<li><a class="dropdown-item" href="blog-masonry-full-width.html">Full Width</a></li>
																	<li><a class="dropdown-item" href="blog-masonry-no-margins.html">No Margins</a></li>
																	<li><a class="dropdown-item" href="blog-masonry-no-margins-full-width.html">No Margins Full Width</a></li>
																	<li><a class="dropdown-item" href="blog-masonry-sidebar-left.html">Left Sidebar</a></li>
																	<li><a class="dropdown-item" href="blog-masonry-sidebar-right.html">Right Sidebar </a></li>
																</ul>
															</li>
															<li class="dropdown-submenu">
																<a class="dropdown-item" href="#">Timeline</a>
																<ul class="dropdown-menu">
																	<li><a class="dropdown-item" href="blog-timeline.html">Full Width</a></li>
																	<li><a class="dropdown-item" href="blog-timeline-sidebar-left.html">Left Sidebar</a></li>
																	<li><a class="dropdown-item" href="blog-timeline-sidebar-right.html">Right Sidebar </a></li>
																</ul>
															</li>
															<li class="dropdown-submenu">
																<a class="dropdown-item" href="#">Single Post</a>
																<ul class="dropdown-menu">
																	<li><a class="dropdown-item" href="blog-post.html">Full Width</a></li>
																	<li><a class="dropdown-item" href="blog-post-slider-gallery.html">Slider Gallery</a></li>
																	<li><a class="dropdown-item" href="blog-post-image-gallery.html">Image Gallery</a></li>
																	<li><a class="dropdown-item" href="blog-post-embedded-video.html">Embedded Video</a></li>
																	<li><a class="dropdown-item" href="blog-post-html5-video.html">HTML5 Video</a></li>
																	<li><a class="dropdown-item" href="blog-post-blockquote.html">Blockquote</a></li>
																	<li><a class="dropdown-item" href="blog-post-link.html">Link</a></li>
																	<li><a class="dropdown-item" href="blog-post-embedded-audio.html">Embedded Audio</a></li>
																	<li><a class="dropdown-item" href="blog-post-small-image.html">Small Image</a></li>
																	<li><a class="dropdown-item" href="blog-post-sidebar-left.html">Left Sidebar</a></li>
																	<li><a class="dropdown-item" href="blog-post-sidebar-right.html">Right Sidebar </a></li>
																	<li><a class="dropdown-item" href="blog-post-sidebar-left-and-right.html">Left and Right Sidebar</a></li>
																</ul>
															</li>
															<li class="dropdown-submenu">
																<a class="dropdown-item" href="#">Post Comments</a>
																<ul class="dropdown-menu">
																	<li><a class="dropdown-item" href="blog-post.html#comments">Default</a></li>
																	<li><a class="dropdown-item" href="blog-post-comments-facebook.html#comments">Facebook Comments</a></li>
																	<li><a class="dropdown-item" href="blog-post-comments-disqus.html#comments">Disqus Comments</a></li>
																</ul>
															</li>
														</ul>
													</li> -->
													<li class="dropdown">
														<a class="dropdown-item dropdown-toggle" href="<?= base_url('auth')?>">
															Login
														</a>
														
													</li>
												</ul>
											</nav>
										</div>
										<button class="btn header-btn-collapse-nav" data-toggle="collapse" data-target=".header-nav-main nav">
											<i class="fas fa-bars"></i>
										</button>
									</div>
									<div class="header-nav-features order-1 order-lg-2">
										<div class="header-nav-feature header-nav-features-social-icons d-inline-flex">
											<ul class="header-social-icons social-icons d-none d-sm-block social-icons-clean ml-0">
												<li class="social-icons-facebook"><a href="http://www.facebook.com/" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
												<li class="social-icons-twitter"><a href="http://www.twitter.com/" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a></li>
												<li class="social-icons-linkedin"><a href="http://www.linkedin.com/" target="_blank" title="Linkedin"><i class="fab fa-linkedin-in"></i></a></li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</header>