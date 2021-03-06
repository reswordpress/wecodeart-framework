export default function hasScrollbar(el) {
	// The Modern solution
	if (typeof window.innerWidth === 'number') return window.innerWidth > document.documentElement.clientWidth;

	// Elem for quirksmode
	var elem = el || document.documentElement || document.body;

	// Check overflow style property on body for fauxscrollbars
	var overflowStyle;

	if (typeof elem.currentStyle !== 'undefined') overflowStyle = elem.currentStyle.overflow;

	overflowStyle = overflowStyle || window.getComputedStyle(elem, '').overflow;

	// Also need to check the Y axis overflow
	var overflowYStyle;

	if (typeof elem.currentStyle !== 'undefined') overflowYStyle = elem.currentStyle.overflowY;

	overflowYStyle = overflowYStyle || window.getComputedStyle(elem, '').overflowY;

	var contentOverflows = elem.scrollHeight > elem.clientHeight;
	var overflowShown = /^(visible|auto)$/.test(overflowStyle) || /^(visible|auto)$/.test(overflowYStyle);
	var alwaysShowScroll = overflowStyle === 'scroll' || overflowYStyle === 'scroll';

	return (contentOverflows && overflowShown) || (alwaysShowScroll);
};

const handleDocumentScrollbar = () => {
	let html = document.documentElement;
	if (hasScrollbar()) html.classList.add('has-scrollbar');
	else html.classList.remove('has-scrollbar');
};

export { handleDocumentScrollbar }; 