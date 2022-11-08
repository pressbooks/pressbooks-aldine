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

eval("document.addEventListener('DOMContentLoaded', function () {\n  var checkbox = document.getElementById('_customize-input-pb_network_contact_form');\n  var email = document.getElementById('customize-control-pb_network_contact_email');\n  var link = document.getElementById('customize-control-pb_network_contact_link');\n  var title = document.getElementById('customize-control-pb_network_contact_form_title');\n  checkbox.addEventListener('click', toggleReadOnly);\n\n  /**\n   *\n   */\n  function toggleReadOnly() {\n    if (checkbox.checked === false) {\n      email.classList.add('hidden');\n      email.style.cssText = null;\n      title.classList.add('hidden');\n      title.style.cssText = null;\n      link.classList.remove('hidden');\n      link.style.cssText = 'display: list-item;';\n    } else {\n      email.classList.remove('hidden');\n      email.style.cssText = 'display: list-item;';\n      title.classList.remove('hidden');\n      title.style.cssText = 'display: list-item;';\n      link.classList.add('hidden');\n      link.style.cssText = null;\n    }\n  }\n  toggleReadOnly();\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJuYW1lcyI6WyJkb2N1bWVudCIsImFkZEV2ZW50TGlzdGVuZXIiLCJjaGVja2JveCIsImdldEVsZW1lbnRCeUlkIiwiZW1haWwiLCJsaW5rIiwidGl0bGUiLCJ0b2dnbGVSZWFkT25seSIsImNoZWNrZWQiLCJjbGFzc0xpc3QiLCJhZGQiLCJzdHlsZSIsImNzc1RleHQiLCJyZW1vdmUiXSwic291cmNlcyI6WyJ3ZWJwYWNrOi8vQHByZXNzYm9va3MvcHJlc3Nib29rcy1hbGRpbmUvLi9hc3NldHMvc2NyaXB0cy9jdXN0b21pemVyLXRvZ2dsZS5qcz8yMTdlIl0sInNvdXJjZXNDb250ZW50IjpbImRvY3VtZW50LmFkZEV2ZW50TGlzdGVuZXIoICdET01Db250ZW50TG9hZGVkJywgZnVuY3Rpb24gKCkge1xuXHRsZXQgY2hlY2tib3ggPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCggJ19jdXN0b21pemUtaW5wdXQtcGJfbmV0d29ya19jb250YWN0X2Zvcm0nICk7XG5cdGxldCBlbWFpbCA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCAnY3VzdG9taXplLWNvbnRyb2wtcGJfbmV0d29ya19jb250YWN0X2VtYWlsJyApO1xuXHRsZXQgbGluayA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCAnY3VzdG9taXplLWNvbnRyb2wtcGJfbmV0d29ya19jb250YWN0X2xpbmsnICk7XG5cdGxldCB0aXRsZSA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCAnY3VzdG9taXplLWNvbnRyb2wtcGJfbmV0d29ya19jb250YWN0X2Zvcm1fdGl0bGUnICk7XG5cblx0Y2hlY2tib3guYWRkRXZlbnRMaXN0ZW5lciggJ2NsaWNrJywgdG9nZ2xlUmVhZE9ubHkgKTtcblxuXHQvKipcblx0ICpcblx0ICovXG5cdGZ1bmN0aW9uIHRvZ2dsZVJlYWRPbmx5KCkge1xuXHRcdGlmICggY2hlY2tib3guY2hlY2tlZCA9PT0gZmFsc2UgKSB7XG5cdFx0XHRlbWFpbC5jbGFzc0xpc3QuYWRkKCAnaGlkZGVuJyApO1xuXHRcdFx0ZW1haWwuc3R5bGUuY3NzVGV4dCA9IG51bGw7XG5cblx0XHRcdHRpdGxlLmNsYXNzTGlzdC5hZGQoICdoaWRkZW4nICk7XG5cdFx0XHR0aXRsZS5zdHlsZS5jc3NUZXh0ID0gbnVsbDtcblxuXHRcdFx0bGluay5jbGFzc0xpc3QucmVtb3ZlKCAnaGlkZGVuJyApO1xuXHRcdFx0bGluay5zdHlsZS5jc3NUZXh0ID0gJ2Rpc3BsYXk6IGxpc3QtaXRlbTsnO1xuXHRcdH0gZWxzZSB7XG5cdFx0XHRlbWFpbC5jbGFzc0xpc3QucmVtb3ZlKCAnaGlkZGVuJyApO1xuXHRcdFx0ZW1haWwuc3R5bGUuY3NzVGV4dCA9ICdkaXNwbGF5OiBsaXN0LWl0ZW07JztcblxuXHRcdFx0dGl0bGUuY2xhc3NMaXN0LnJlbW92ZSggJ2hpZGRlbicgKTtcblx0XHRcdHRpdGxlLnN0eWxlLmNzc1RleHQgPSAnZGlzcGxheTogbGlzdC1pdGVtOyc7XG5cblx0XHRcdGxpbmsuY2xhc3NMaXN0LmFkZCggJ2hpZGRlbicgKTtcblx0XHRcdGxpbmsuc3R5bGUuY3NzVGV4dCA9IG51bGw7XG5cdFx0fVxuXHR9XG5cblx0dG9nZ2xlUmVhZE9ubHkoKTtcblxufSApO1xuIl0sIm1hcHBpbmdzIjoiQUFBQUEsUUFBUSxDQUFDQyxnQkFBZ0IsQ0FBRSxrQkFBa0IsRUFBRSxZQUFZO0VBQzFELElBQUlDLFFBQVEsR0FBR0YsUUFBUSxDQUFDRyxjQUFjLENBQUUsMENBQTBDLENBQUU7RUFDcEYsSUFBSUMsS0FBSyxHQUFHSixRQUFRLENBQUNHLGNBQWMsQ0FBRSw0Q0FBNEMsQ0FBRTtFQUNuRixJQUFJRSxJQUFJLEdBQUdMLFFBQVEsQ0FBQ0csY0FBYyxDQUFFLDJDQUEyQyxDQUFFO0VBQ2pGLElBQUlHLEtBQUssR0FBR04sUUFBUSxDQUFDRyxjQUFjLENBQUUsaURBQWlELENBQUU7RUFFeEZELFFBQVEsQ0FBQ0QsZ0JBQWdCLENBQUUsT0FBTyxFQUFFTSxjQUFjLENBQUU7O0VBRXBEO0FBQ0Q7QUFDQTtFQUNDLFNBQVNBLGNBQWMsR0FBRztJQUN6QixJQUFLTCxRQUFRLENBQUNNLE9BQU8sS0FBSyxLQUFLLEVBQUc7TUFDakNKLEtBQUssQ0FBQ0ssU0FBUyxDQUFDQyxHQUFHLENBQUUsUUFBUSxDQUFFO01BQy9CTixLQUFLLENBQUNPLEtBQUssQ0FBQ0MsT0FBTyxHQUFHLElBQUk7TUFFMUJOLEtBQUssQ0FBQ0csU0FBUyxDQUFDQyxHQUFHLENBQUUsUUFBUSxDQUFFO01BQy9CSixLQUFLLENBQUNLLEtBQUssQ0FBQ0MsT0FBTyxHQUFHLElBQUk7TUFFMUJQLElBQUksQ0FBQ0ksU0FBUyxDQUFDSSxNQUFNLENBQUUsUUFBUSxDQUFFO01BQ2pDUixJQUFJLENBQUNNLEtBQUssQ0FBQ0MsT0FBTyxHQUFHLHFCQUFxQjtJQUMzQyxDQUFDLE1BQU07TUFDTlIsS0FBSyxDQUFDSyxTQUFTLENBQUNJLE1BQU0sQ0FBRSxRQUFRLENBQUU7TUFDbENULEtBQUssQ0FBQ08sS0FBSyxDQUFDQyxPQUFPLEdBQUcscUJBQXFCO01BRTNDTixLQUFLLENBQUNHLFNBQVMsQ0FBQ0ksTUFBTSxDQUFFLFFBQVEsQ0FBRTtNQUNsQ1AsS0FBSyxDQUFDSyxLQUFLLENBQUNDLE9BQU8sR0FBRyxxQkFBcUI7TUFFM0NQLElBQUksQ0FBQ0ksU0FBUyxDQUFDQyxHQUFHLENBQUUsUUFBUSxDQUFFO01BQzlCTCxJQUFJLENBQUNNLEtBQUssQ0FBQ0MsT0FBTyxHQUFHLElBQUk7SUFDMUI7RUFDRDtFQUVBTCxjQUFjLEVBQUU7QUFFakIsQ0FBQyxDQUFFIiwiZmlsZSI6Ii4vYXNzZXRzL3NjcmlwdHMvY3VzdG9taXplci10b2dnbGUuanMuanMiLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///./assets/scripts/customizer-toggle.js\n");

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