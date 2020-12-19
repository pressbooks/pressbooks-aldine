module.exports = {
	"scripts": {
      postbump: "composer readme"
    },
	"bumpFiles": [
		{
			filename: "style.css",
			updater: "bin/version-style.js"
		},
		{
			filename: "readme.txt",
			updater: "bin/version-readme.js"
		}
	]
}
