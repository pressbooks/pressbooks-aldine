/*
 * ATTENTION: An "eval-source-map" devtool has been used.
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file with attached SourceMaps in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (function() { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./assets/scripts/customizer-toggle.js":
/*!*********************************************!*\
  !*** ./assets/scripts/customizer-toggle.js ***!
  \*********************************************/
/***/ (function() {

eval("document.addEventListener('DOMContentLoaded', function () {\n  var checkbox = document.getElementById('_customize-input-pb_network_contact_form');\n  var email = document.getElementById('customize-control-pb_network_contact_email');\n  var link = document.getElementById('customize-control-pb_network_contact_link');\n  var title = document.getElementById('customize-control-pb_network_contact_form_title');\n  checkbox.addEventListener('click', toggleReadOnly);\n  /**\n   *\n   */\n\n  function toggleReadOnly() {\n    if (checkbox.checked === false) {\n      email.classList.add('hidden');\n      email.style.cssText = null;\n      title.classList.add('hidden');\n      title.style.cssText = null;\n      link.classList.remove('hidden');\n      link.style.cssText = 'display: list-item;';\n    } else {\n      email.classList.remove('hidden');\n      email.style.cssText = 'display: list-item;';\n      title.classList.remove('hidden');\n      title.style.cssText = 'display: list-item;';\n      link.classList.add('hidden');\n      link.style.cssText = null;\n    }\n  }\n\n  toggleReadOnly();\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly9AcHJlc3Nib29rcy9wcmVzc2Jvb2tzLWFsZGluZS8uL2Fzc2V0cy9zY3JpcHRzL2N1c3RvbWl6ZXItdG9nZ2xlLmpzP2U0Y2IiXSwibmFtZXMiOlsiZG9jdW1lbnQiLCJhZGRFdmVudExpc3RlbmVyIiwiY2hlY2tib3giLCJnZXRFbGVtZW50QnlJZCIsImVtYWlsIiwibGluayIsInRpdGxlIiwidG9nZ2xlUmVhZE9ubHkiLCJjaGVja2VkIiwiY2xhc3NMaXN0IiwiYWRkIiwic3R5bGUiLCJjc3NUZXh0IiwicmVtb3ZlIl0sIm1hcHBpbmdzIjoiQUFBQUEsUUFBUSxDQUFDQyxnQkFBVCxDQUEyQixrQkFBM0IsRUFBK0MsWUFBWTtBQUMxRCxNQUFJQyxRQUFRLEdBQUdGLFFBQVEsQ0FBQ0csY0FBVCxDQUF5QiwwQ0FBekIsQ0FBZjtBQUNBLE1BQUlDLEtBQUssR0FBR0osUUFBUSxDQUFDRyxjQUFULENBQXlCLDRDQUF6QixDQUFaO0FBQ0EsTUFBSUUsSUFBSSxHQUFHTCxRQUFRLENBQUNHLGNBQVQsQ0FBeUIsMkNBQXpCLENBQVg7QUFDQSxNQUFJRyxLQUFLLEdBQUdOLFFBQVEsQ0FBQ0csY0FBVCxDQUF5QixpREFBekIsQ0FBWjtBQUVBRCxFQUFBQSxRQUFRLENBQUNELGdCQUFULENBQTJCLE9BQTNCLEVBQW9DTSxjQUFwQztBQUVBO0FBQ0Q7QUFDQTs7QUFDQyxXQUFTQSxjQUFULEdBQTBCO0FBQ3pCLFFBQUtMLFFBQVEsQ0FBQ00sT0FBVCxLQUFxQixLQUExQixFQUFrQztBQUNqQ0osTUFBQUEsS0FBSyxDQUFDSyxTQUFOLENBQWdCQyxHQUFoQixDQUFxQixRQUFyQjtBQUNBTixNQUFBQSxLQUFLLENBQUNPLEtBQU4sQ0FBWUMsT0FBWixHQUFzQixJQUF0QjtBQUVBTixNQUFBQSxLQUFLLENBQUNHLFNBQU4sQ0FBZ0JDLEdBQWhCLENBQXFCLFFBQXJCO0FBQ0FKLE1BQUFBLEtBQUssQ0FBQ0ssS0FBTixDQUFZQyxPQUFaLEdBQXNCLElBQXRCO0FBRUFQLE1BQUFBLElBQUksQ0FBQ0ksU0FBTCxDQUFlSSxNQUFmLENBQXVCLFFBQXZCO0FBQ0FSLE1BQUFBLElBQUksQ0FBQ00sS0FBTCxDQUFXQyxPQUFYLEdBQXFCLHFCQUFyQjtBQUNBLEtBVEQsTUFTTztBQUNOUixNQUFBQSxLQUFLLENBQUNLLFNBQU4sQ0FBZ0JJLE1BQWhCLENBQXdCLFFBQXhCO0FBQ0FULE1BQUFBLEtBQUssQ0FBQ08sS0FBTixDQUFZQyxPQUFaLEdBQXNCLHFCQUF0QjtBQUVBTixNQUFBQSxLQUFLLENBQUNHLFNBQU4sQ0FBZ0JJLE1BQWhCLENBQXdCLFFBQXhCO0FBQ0FQLE1BQUFBLEtBQUssQ0FBQ0ssS0FBTixDQUFZQyxPQUFaLEdBQXNCLHFCQUF0QjtBQUVBUCxNQUFBQSxJQUFJLENBQUNJLFNBQUwsQ0FBZUMsR0FBZixDQUFvQixRQUFwQjtBQUNBTCxNQUFBQSxJQUFJLENBQUNNLEtBQUwsQ0FBV0MsT0FBWCxHQUFxQixJQUFyQjtBQUNBO0FBQ0Q7O0FBRURMLEVBQUFBLGNBQWM7QUFFZCxDQW5DRCIsInNvdXJjZXNDb250ZW50IjpbImRvY3VtZW50LmFkZEV2ZW50TGlzdGVuZXIoICdET01Db250ZW50TG9hZGVkJywgZnVuY3Rpb24gKCkge1xuXHRsZXQgY2hlY2tib3ggPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCggJ19jdXN0b21pemUtaW5wdXQtcGJfbmV0d29ya19jb250YWN0X2Zvcm0nICk7XG5cdGxldCBlbWFpbCA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCAnY3VzdG9taXplLWNvbnRyb2wtcGJfbmV0d29ya19jb250YWN0X2VtYWlsJyApO1xuXHRsZXQgbGluayA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCAnY3VzdG9taXplLWNvbnRyb2wtcGJfbmV0d29ya19jb250YWN0X2xpbmsnICk7XG5cdGxldCB0aXRsZSA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCAnY3VzdG9taXplLWNvbnRyb2wtcGJfbmV0d29ya19jb250YWN0X2Zvcm1fdGl0bGUnICk7XG5cblx0Y2hlY2tib3guYWRkRXZlbnRMaXN0ZW5lciggJ2NsaWNrJywgdG9nZ2xlUmVhZE9ubHkgKTtcblxuXHQvKipcblx0ICpcblx0ICovXG5cdGZ1bmN0aW9uIHRvZ2dsZVJlYWRPbmx5KCkge1xuXHRcdGlmICggY2hlY2tib3guY2hlY2tlZCA9PT0gZmFsc2UgKSB7XG5cdFx0XHRlbWFpbC5jbGFzc0xpc3QuYWRkKCAnaGlkZGVuJyApO1xuXHRcdFx0ZW1haWwuc3R5bGUuY3NzVGV4dCA9IG51bGw7XG5cblx0XHRcdHRpdGxlLmNsYXNzTGlzdC5hZGQoICdoaWRkZW4nICk7XG5cdFx0XHR0aXRsZS5zdHlsZS5jc3NUZXh0ID0gbnVsbDtcblxuXHRcdFx0bGluay5jbGFzc0xpc3QucmVtb3ZlKCAnaGlkZGVuJyApO1xuXHRcdFx0bGluay5zdHlsZS5jc3NUZXh0ID0gJ2Rpc3BsYXk6IGxpc3QtaXRlbTsnO1xuXHRcdH0gZWxzZSB7XG5cdFx0XHRlbWFpbC5jbGFzc0xpc3QucmVtb3ZlKCAnaGlkZGVuJyApO1xuXHRcdFx0ZW1haWwuc3R5bGUuY3NzVGV4dCA9ICdkaXNwbGF5OiBsaXN0LWl0ZW07JztcblxuXHRcdFx0dGl0bGUuY2xhc3NMaXN0LnJlbW92ZSggJ2hpZGRlbicgKTtcblx0XHRcdHRpdGxlLnN0eWxlLmNzc1RleHQgPSAnZGlzcGxheTogbGlzdC1pdGVtOyc7XG5cblx0XHRcdGxpbmsuY2xhc3NMaXN0LmFkZCggJ2hpZGRlbicgKTtcblx0XHRcdGxpbmsuc3R5bGUuY3NzVGV4dCA9IG51bGw7XG5cdFx0fVxuXHR9XG5cblx0dG9nZ2xlUmVhZE9ubHkoKTtcblxufSApO1xuIl0sImZpbGUiOiIuL2Fzc2V0cy9zY3JpcHRzL2N1c3RvbWl6ZXItdG9nZ2xlLmpzLmpzIiwic291cmNlUm9vdCI6IiJ9\n//# sourceURL=webpack-internal:///./assets/scripts/customizer-toggle.js\n");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval-source-map devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./assets/scripts/customizer-toggle.js"]();
/******/ 	
/******/ })()
;