/*
 * jQuery wooslider v2.2.0
 * http://www.woothemes.com/wooslider/
 *
 * Copyright 2012 WooThemes
 * Free to use under the GPLv2 license.
 * http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Contributing author: Tyler Smith (@mbmufffin)
 */


/* Browser Resets
*********************************/
.wooslider-container a:active,
.wooslider a:active,
.wooslider-container a:focus,
.wooslider a:focus  {outline: none;}
.slides,
.wooslider-control-nav,
.wooslider-direction-nav {margin: 0; padding: 0; list-style: none;}

/* Icon Fonts
*********************************/
/* Font-face Icons */
@font-face {
	font-family: 'flexslider-icon';
	src:url('../fonts/flexslider-icon.eot');
	src:url('../fonts/flexslider-icon.eot?#iefix') format('embedded-opentype'),
		url('../fonts/flexslider-icon.woff') format('woff'),
		url('../fonts/flexslider-icon.ttf') format('truetype'),
		url('../fonts/flexslider-icon.svg#flexslider-icon') format('svg');
	font-weight: normal;
	font-style: normal;
}

/* wooslider Necessary Styles
*********************************/
.wooslider {margin: 0; padding: 0;}
.wooslider .slides > li {display: none; -webkit-backface-visibility: hidden;} /* Hide the slides before the JS is loaded. Avoids image jumping */
.wooslider .slides img {width: 100%; display: block;}
.wooslider-pauseplay span {text-transform: capitalize;}

/* Clearfix for the .slides element */
.slides:after {content: "\0020"; display: block; clear: both; visibility: hidden; line-height: 0; height: 0;}
html[xmlns] .slides {display: block;}
* html .slides {height: 1%;}

/* No JavaScript Fallback */
/* If you are not using another script, such as Modernizr, make sure you
 * include js that eliminates this class on page load */
.no-js .slides > li:first-child {display: block;}

/* wooslider Default Theme
*********************************/
.wooslider { margin: 0 0 60px; background: #fff; border: 4px solid #fff; position: relative; -webkit-border-radius: 4px; -moz-border-radius: 4px; -o-border-radius: 4px; border-radius: 4px; -webkit-box-shadow: 0 1px 4px rgba(0,0,0,.2); -moz-box-shadow: 0 1px 4px rgba(0,0,0,.2); -o-box-shadow: 0 1px 4px rgba(0,0,0,.2); box-shadow: 0 1px 4px rgba(0,0,0,.2); zoom: 1; }
.wooslider-viewport { max-height: 2000px; -webkit-transition: all 1s ease; -moz-transition: all 1s ease; -o-transition: all 1s ease; transition: all 1s ease; }
.loading .wooslider-viewport { max-height: 300px; }
.wooslider .slides { zoom: 1; }
.carousel li { margin-right: 5px; }

/* Direction Nav */
.wooslider-direction-nav {*height: 0;}
.wooslider-direction-nav a  { display: block; width: 40px; height: 40px; margin: -20px 0 0; position: absolute; top: 50%; z-index: 10; overflow: hidden; opacity: 0; cursor: pointer; color: rgba(0,0,0,0.8); text-shadow: 1px 1px 0 rgba(255,255,255,0.3); -webkit-transition: all .3s ease; -moz-transition: all .3s ease; transition: all .3s ease; }
.wooslider-direction-nav .wooslider-prev { left: -50px; }
.wooslider-direction-nav .wooslider-next { right: -50px; text-align: right; }
.wooslider:hover .wooslider-prev { opacity: 0.7; left: 10px; }
.wooslider:hover .wooslider-next { opacity: 0.7; right: 10px; }
.wooslider:hover .wooslider-next:hover, .wooslider:hover .wooslider-prev:hover { opacity: 1; }
.wooslider-direction-nav .wooslider-disabled { opacity: 0!important; filter:alpha(opacity=0); cursor: default; }
.wooslider-direction-nav a:before  { font-family: "flexslider-icon"; font-size: 40px; display: inline-block; content: '\f001'; }
.wooslider-direction-nav a.wooslider-next:before  { content: '\f002'; }

/* Pause/Play */
.wooslider-pauseplay a { display: block; width: 20px; height: 20px; position: absolute; bottom: 5px; left: 10px; opacity: 0.8; z-index: 10; overflow: hidden; cursor: pointer; color: #000; }
.wooslider-pauseplay a:before  { font-family: "flexslider-icon"; font-size: 20px; display: inline-block; content: '\f004'; }
.wooslider-pauseplay a:hover  { opacity: 1; }
.wooslider-pauseplay a.wooslider-play:before { content: '\f003'; }

/* Control Nav */
.wooslider-control-nav {width: 100%; position: absolute; bottom: -40px; text-align: center;}
.wooslider-control-nav li {margin: 0 6px; display: inline-block; zoom: 1; *display: inline;}
.wooslider-control-paging li a {width: 11px; height: 11px; display: block; background: #666; background: rgba(0,0,0,0.5); cursor: pointer; text-indent: -9999px; -webkit-border-radius: 20px; -moz-border-radius: 20px; -o-border-radius: 20px; border-radius: 20px; -webkit-box-shadow: inset 0 0 3px rgba(0,0,0,0.3); -moz-box-shadow: inset 0 0 3px rgba(0,0,0,0.3); -o-box-shadow: inset 0 0 3px rgba(0,0,0,0.3); box-shadow: inset 0 0 3px rgba(0,0,0,0.3); }
.wooslider-control-paging li a:hover { background: #333; background: rgba(0,0,0,0.7); }
.wooslider-control-paging li a.wooslider-active { background: #000; background: rgba(0,0,0,0.9); cursor: default; }

.wooslider-control-thumbs {margin: 5px 0 0; position: static; overflow: hidden;}
.wooslider-control-thumbs li {width: 25%; float: left; margin: 0;}
.wooslider-control-thumbs img {width: 100%; display: block; opacity: .7; cursor: pointer;}
.wooslider-control-thumbs img:hover {opacity: 1;}
.wooslider-control-thumbs .wooslider-active {opacity: 1; cursor: default;}

@media screen and (max-width: 860px) {
  .wooslider-direction-nav .wooslider-prev { opacity: 1; left: 10px;}
  .wooslider-direction-nav .wooslider-next { opacity: 1; right: 10px;}
}