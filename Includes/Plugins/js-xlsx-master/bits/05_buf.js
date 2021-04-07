var has_buf = (typeof Buffer !== 'undefined' && typeof process !== 'undefined' && typeof process.versions !== 'undefined' && process.versions.node);

function new_raw_buf(len/*:number*/) {
	/* jshint -W056 */
	// $FlowIgnore
	return new (has_buf ? Buffer : Array)(len);
	/* jshint +W056 */
}

function s2a(s/*:string*/) {
	if(has_buf) return new Buffer(s, "binary");
	return s.split("").map(function(x){ return x.charCodeAt(0) & 0xff; });
}

var bconcat = function(bufs) { return [].concat.apply([], bufs); };

var chr0 = /\u0000/g, chr1 = /[\u0001-\u0006]/;
