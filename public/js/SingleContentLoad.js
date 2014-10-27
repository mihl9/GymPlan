function load(seite)
{
	$.ajax(
		{
			url: seite,
			type: 'post',
			dataType: 'text',
			async: true,
			success: function(response)
			{
				document.getElementById("content").innerHTML = response;
			}
		});
}