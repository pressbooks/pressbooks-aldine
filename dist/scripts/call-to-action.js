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

/***/ "./assets/scripts/call-to-action.js":
/*!******************************************!*\
  !*** ./assets/scripts/call-to-action.js ***!
  \******************************************/
/***/ (function() {

eval("(function () {\n  tinymce.create('tinymce.plugins.aldine_call_to_action', {\n    /**\n     * @param editor\n     * @param url\n     */\n    init: function init(editor, url) {\n      editor.addButton('aldine_call_to_action', {\n        title: aldine.call_to_action.title,\n        icon: 'icon dashicons-flag',\n\n        /**\n         *\n         */\n        onclick: function onclick() {\n          editor.windowManager.open({\n            title: aldine.call_to_action.title,\n            body: [{\n              type: 'textbox',\n              name: 'text',\n              label: aldine.call_to_action.text,\n              value: aldine.call_to_action.title\n            }, {\n              type: 'textbox',\n              name: 'link',\n              label: aldine.call_to_action.link,\n              value: '#'\n            }],\n\n            /**\n             * @param e\n             */\n            onsubmit: function onsubmit(e) {\n              editor.insertContent('[aldine_call_to_action text=\"' + e.data.text + '\" link=\"' + e.data.link + '\"]');\n            }\n          });\n        }\n      });\n    },\n\n    /**\n     * @param n\n     * @param cm\n     */\n    createControl: function createControl(n, cm) {\n      return null;\n    }\n  });\n  tinymce.PluginManager.add('aldine_call_to_action', tinymce.plugins.aldine_call_to_action);\n})();//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly9AcHJlc3Nib29rcy9wcmVzc2Jvb2tzLWFsZGluZS8uL2Fzc2V0cy9zY3JpcHRzL2NhbGwtdG8tYWN0aW9uLmpzP2RiZTYiXSwibmFtZXMiOlsidGlueW1jZSIsImNyZWF0ZSIsImluaXQiLCJlZGl0b3IiLCJ1cmwiLCJhZGRCdXR0b24iLCJ0aXRsZSIsImFsZGluZSIsImNhbGxfdG9fYWN0aW9uIiwiaWNvbiIsIm9uY2xpY2siLCJ3aW5kb3dNYW5hZ2VyIiwib3BlbiIsImJvZHkiLCJ0eXBlIiwibmFtZSIsImxhYmVsIiwidGV4dCIsInZhbHVlIiwibGluayIsIm9uc3VibWl0IiwiZSIsImluc2VydENvbnRlbnQiLCJkYXRhIiwiY3JlYXRlQ29udHJvbCIsIm4iLCJjbSIsIlBsdWdpbk1hbmFnZXIiLCJhZGQiLCJwbHVnaW5zIiwiYWxkaW5lX2NhbGxfdG9fYWN0aW9uIl0sIm1hcHBpbmdzIjoiQUFBQSxDQUFFLFlBQVk7QUFDYkEsRUFBQUEsT0FBTyxDQUFDQyxNQUFSLENBQWdCLHVDQUFoQixFQUF5RDtBQUN4RDtBQUNGO0FBQ0E7QUFDQTtBQUNFQyxJQUFBQSxJQUFJLEVBQUUsY0FBV0MsTUFBWCxFQUFtQkMsR0FBbkIsRUFBeUI7QUFDOUJELE1BQUFBLE1BQU0sQ0FBQ0UsU0FBUCxDQUFrQix1QkFBbEIsRUFBMkM7QUFDMUNDLFFBQUFBLEtBQUssRUFBRUMsTUFBTSxDQUFDQyxjQUFQLENBQXNCRixLQURhO0FBRTFDRyxRQUFBQSxJQUFJLEVBQUUscUJBRm9DOztBQUcxQztBQUNKO0FBQ0E7QUFDSUMsUUFBQUEsT0FBTyxFQUFFLG1CQUFZO0FBQ3BCUCxVQUFBQSxNQUFNLENBQUNRLGFBQVAsQ0FBcUJDLElBQXJCLENBQTJCO0FBQzFCTixZQUFBQSxLQUFLLEVBQUVDLE1BQU0sQ0FBQ0MsY0FBUCxDQUFzQkYsS0FESDtBQUUxQk8sWUFBQUEsSUFBSSxFQUFFLENBQ0w7QUFDQ0MsY0FBQUEsSUFBSSxFQUFFLFNBRFA7QUFFQ0MsY0FBQUEsSUFBSSxFQUFFLE1BRlA7QUFHQ0MsY0FBQUEsS0FBSyxFQUFFVCxNQUFNLENBQUNDLGNBQVAsQ0FBc0JTLElBSDlCO0FBSUNDLGNBQUFBLEtBQUssRUFBRVgsTUFBTSxDQUFDQyxjQUFQLENBQXNCRjtBQUo5QixhQURLLEVBT0w7QUFDQ1EsY0FBQUEsSUFBSSxFQUFFLFNBRFA7QUFFQ0MsY0FBQUEsSUFBSSxFQUFFLE1BRlA7QUFHQ0MsY0FBQUEsS0FBSyxFQUFFVCxNQUFNLENBQUNDLGNBQVAsQ0FBc0JXLElBSDlCO0FBSUNELGNBQUFBLEtBQUssRUFBRTtBQUpSLGFBUEssQ0FGb0I7O0FBZ0IxQjtBQUNOO0FBQ0E7QUFDTUUsWUFBQUEsUUFBUSxFQUFFLGtCQUFXQyxDQUFYLEVBQWU7QUFDeEJsQixjQUFBQSxNQUFNLENBQUNtQixhQUFQLENBQ0Msa0NBQ0NELENBQUMsQ0FBQ0UsSUFBRixDQUFPTixJQURSLEdBRUMsVUFGRCxHQUdDSSxDQUFDLENBQUNFLElBQUYsQ0FBT0osSUFIUixHQUlDLElBTEY7QUFPQTtBQTNCeUIsV0FBM0I7QUE2QkE7QUFwQ3lDLE9BQTNDO0FBc0NBLEtBNUN1RDs7QUE2Q3hEO0FBQ0Y7QUFDQTtBQUNBO0FBQ0VLLElBQUFBLGFBQWEsRUFBRSx1QkFBV0MsQ0FBWCxFQUFjQyxFQUFkLEVBQW1CO0FBQ2pDLGFBQU8sSUFBUDtBQUNBO0FBbkR1RCxHQUF6RDtBQXFEQTFCLEVBQUFBLE9BQU8sQ0FBQzJCLGFBQVIsQ0FBc0JDLEdBQXRCLENBQ0MsdUJBREQsRUFFQzVCLE9BQU8sQ0FBQzZCLE9BQVIsQ0FBZ0JDLHFCQUZqQjtBQUlBLENBMUREIiwic291cmNlc0NvbnRlbnQiOlsiKCBmdW5jdGlvbiAoKSB7XG5cdHRpbnltY2UuY3JlYXRlKCAndGlueW1jZS5wbHVnaW5zLmFsZGluZV9jYWxsX3RvX2FjdGlvbicsIHtcblx0XHQvKipcblx0XHQgKiBAcGFyYW0gZWRpdG9yXG5cdFx0ICogQHBhcmFtIHVybFxuXHRcdCAqL1xuXHRcdGluaXQ6IGZ1bmN0aW9uICggZWRpdG9yLCB1cmwgKSB7XG5cdFx0XHRlZGl0b3IuYWRkQnV0dG9uKCAnYWxkaW5lX2NhbGxfdG9fYWN0aW9uJywge1xuXHRcdFx0XHR0aXRsZTogYWxkaW5lLmNhbGxfdG9fYWN0aW9uLnRpdGxlLFxuXHRcdFx0XHRpY29uOiAnaWNvbiBkYXNoaWNvbnMtZmxhZycsXG5cdFx0XHRcdC8qKlxuXHRcdFx0XHQgKlxuXHRcdFx0XHQgKi9cblx0XHRcdFx0b25jbGljazogZnVuY3Rpb24gKCkge1xuXHRcdFx0XHRcdGVkaXRvci53aW5kb3dNYW5hZ2VyLm9wZW4oIHtcblx0XHRcdFx0XHRcdHRpdGxlOiBhbGRpbmUuY2FsbF90b19hY3Rpb24udGl0bGUsXG5cdFx0XHRcdFx0XHRib2R5OiBbXG5cdFx0XHRcdFx0XHRcdHtcblx0XHRcdFx0XHRcdFx0XHR0eXBlOiAndGV4dGJveCcsXG5cdFx0XHRcdFx0XHRcdFx0bmFtZTogJ3RleHQnLFxuXHRcdFx0XHRcdFx0XHRcdGxhYmVsOiBhbGRpbmUuY2FsbF90b19hY3Rpb24udGV4dCxcblx0XHRcdFx0XHRcdFx0XHR2YWx1ZTogYWxkaW5lLmNhbGxfdG9fYWN0aW9uLnRpdGxlLFxuXHRcdFx0XHRcdFx0XHR9LFxuXHRcdFx0XHRcdFx0XHR7XG5cdFx0XHRcdFx0XHRcdFx0dHlwZTogJ3RleHRib3gnLFxuXHRcdFx0XHRcdFx0XHRcdG5hbWU6ICdsaW5rJyxcblx0XHRcdFx0XHRcdFx0XHRsYWJlbDogYWxkaW5lLmNhbGxfdG9fYWN0aW9uLmxpbmssXG5cdFx0XHRcdFx0XHRcdFx0dmFsdWU6ICcjJyxcblx0XHRcdFx0XHRcdFx0fSxcblx0XHRcdFx0XHRcdF0sXG5cdFx0XHRcdFx0XHQvKipcblx0XHRcdFx0XHRcdCAqIEBwYXJhbSBlXG5cdFx0XHRcdFx0XHQgKi9cblx0XHRcdFx0XHRcdG9uc3VibWl0OiBmdW5jdGlvbiAoIGUgKSB7XG5cdFx0XHRcdFx0XHRcdGVkaXRvci5pbnNlcnRDb250ZW50KFxuXHRcdFx0XHRcdFx0XHRcdCdbYWxkaW5lX2NhbGxfdG9fYWN0aW9uIHRleHQ9XCInICtcblx0XHRcdFx0XHRcdFx0XHRcdGUuZGF0YS50ZXh0ICtcblx0XHRcdFx0XHRcdFx0XHRcdCdcIiBsaW5rPVwiJyArXG5cdFx0XHRcdFx0XHRcdFx0XHRlLmRhdGEubGluayArXG5cdFx0XHRcdFx0XHRcdFx0XHQnXCJdJ1xuXHRcdFx0XHRcdFx0XHQpO1xuXHRcdFx0XHRcdFx0fSxcblx0XHRcdFx0XHR9ICk7XG5cdFx0XHRcdH0sXG5cdFx0XHR9ICk7XG5cdFx0fSxcblx0XHQvKipcblx0XHQgKiBAcGFyYW0gblxuXHRcdCAqIEBwYXJhbSBjbVxuXHRcdCAqL1xuXHRcdGNyZWF0ZUNvbnRyb2w6IGZ1bmN0aW9uICggbiwgY20gKSB7XG5cdFx0XHRyZXR1cm4gbnVsbDtcblx0XHR9LFxuXHR9ICk7XG5cdHRpbnltY2UuUGx1Z2luTWFuYWdlci5hZGQoXG5cdFx0J2FsZGluZV9jYWxsX3RvX2FjdGlvbicsXG5cdFx0dGlueW1jZS5wbHVnaW5zLmFsZGluZV9jYWxsX3RvX2FjdGlvblxuXHQpO1xufSApKCk7XG4iXSwiZmlsZSI6Ii4vYXNzZXRzL3NjcmlwdHMvY2FsbC10by1hY3Rpb24uanMuanMiLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///./assets/scripts/call-to-action.js\n");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval-source-map devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./assets/scripts/call-to-action.js"]();
/******/ 	
/******/ })()
;