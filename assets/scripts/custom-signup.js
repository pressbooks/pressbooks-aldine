import Typed from "typed.js";

document.addEventListener('DOMContentLoaded', function () {
	let options = {
		strings: ['open textbook', 'scholarly monograph', 'world-changing manifesto', 'graduate thesis', 'reference guide', 'essay collection', 'student portfolio', 'novel', 'position paper', 'handbook', 'magnum opus', 'research report', 'daybook', 'collected works'],
		typeSpeed: 80,
		backSpeed: 40,
		backDelay: 400,
		loop: true,
	};

	new Typed('#typed', options);
});
