module.exports.readVersion = function(contents) {
	const pattern = /Stable tag:\s*([0-9]*.*)/i;
	return contents.match(pattern)[1];
};

module.exports.writeVersion = function(contents, version) {
	const pattern = /Stable tag:\s*([0-9]*.*)/i;
	const oldVersion = contents.match(pattern)[1];
	return contents.replace(oldVersion, version);
};
