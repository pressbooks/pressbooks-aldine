module.exports = {
	"scripts": {
      postbump: "composer readme"
    },
	"skip": {
		commit: true,
		tag: true
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
