Bloodhound = require('corejs-typeahead/dist/bloodhound.js');
require('corejs-typeahead/dist/typeahead.jquery.js');

var architects = new Bloodhound({
	queryTokenizer: Bloodhound.tokenizers.whitespace,
	datumTokenizer: Bloodhound.tokenizers.whitespace,
	remote: {
		url: '/api/architekti/suggest/?search=%QUERY',
		wildcard: '%QUERY',
		filter: function (architects) {
			return $.map(architects, function (item) {
				return {
					url: item.url,
					value: item.full_name
				};
			});
		}
	}
});

var buildings = new Bloodhound({
	queryTokenizer: Bloodhound.tokenizers.whitespace,
	datumTokenizer: Bloodhound.tokenizers.whitespace,
	remote: {
		url: '/api/objekty/suggest/?search=%QUERY',
		wildcard: '%QUERY',
		filter: function (buildings) {
			return $.map(buildings, function (item) {
				return {
					url: item.url,
					architect_names: item.architect_names,
					title: item.title
                };
            });
		}
	}
});


$("document").ready(function() {

	buildings.initialize();
	architects.initialize();

	$search = $('#search');

	$search.typeahead(
	{
		hint: false,
		highlight: true,
		minLength: 2
	},
	{
		name: 'architects',
		displayKey: 'value',
		limit: 3,
		source: architects.ttAdapter(),
		templates: {
			header: '<h3 class="suggest-type-name my-0 pt-3 pb-1 ls-3">' + $search.data('architects-title') + '</h3>',
			suggestion: function (data) {
				return '<div>'+data.value+'</div>';
			}
		}
	},
	{
		name: 'buildings',
		displayKey: 'value',
		limit: 4,
		source: buildings.ttAdapter(),
		templates: {
			header: '<h3 class="suggest-type-name my-0 pt-3 pb-1 ls-3">'+ $search.data('objects-title') +'</h3>',
			suggestion: function (data) {
				return '<div>' + data.title + '<br><span class="">' + data.architect_names + '</span></div>';
			}
		}
	}).bind("typeahead:select", function(event, object, name) {
		if (object.hasOwnProperty('url')) {
			window.location.href = object.url;
			return;
		}
		$(this).parents('form:first').submit();
	});

	$search.focus();

});