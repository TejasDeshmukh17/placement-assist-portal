// youtube key  AIzaSyB4C6H7wtPkEP6JKzxltKfFFmlDrIGYWfk


$(document).ready(function () {

    var key = 'AIzaSyB4C6H7wtPkEP6JKzxltKfFFmlDrIGYWfk';
    var playlistId = 'PLBlnK6fEyqRiVhbXDGLXDk_OQAeuVcp2O';
    var URL = 'https://www.googleapis.com/youtube/v3/playlistItems';


    var options = {
        part: 'snippet',
        key: key,
        maxResults: 1000,
        playlistId: playlistId
    }

    loadVids();

    function loadVids() {
        $.getJSON(URL, options, function (data) {
            var id = data.items[0].snippet.resourceId.videoId;
            mainVid(id);
            resultsLoop(data);
        });
    }

    function mainVid(id) {
        $('#video').html(`
					<iframe width="100%" height="430" src="https://www.youtube.com/embed/${id}"  class="rounded-[15px]" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
				`);
    }

		
    function resultsLoop(data) {

        $.each(data.items, function (i, item) {

            var thumb = item.snippet.thumbnails.medium.url;
            var title = item.snippet.title;
            var desc = item.snippet.description.substring(0, 100);
            var vid = item.snippet.resourceId.videoId;


            $('main').append(`
            <article class="flex justify-center items-center cursor-pointer w-5/6 h-[140px] bg-[#3d3d3d] mx-auto mb-[15px] rounded-[20px] shadow-[5px_0px_10px_5px_rgba(0,0,0,0.25)] border-[1px] border-black hover:-translate-y-1 transform transition"  data-key="${vid}" >
            <div class="w-[325px] h-[105px]  border-r-2  border-gray-400 " >
                <img src="${thumb}" alt="" class="w-[305px] h-full rounded-[12px]">
            </div>

            <div class="w-[400px] h-[105px] ml-[40px]">
                <p class="text-[20px] text-white "> ${title}</p>
            </div>
            
        </article>`);
        });
    }

		// CLICK EVENT
    $('main').on('click', 'article', function () {
        var id = $(this).attr('data-key');
        mainVid(id);
        window.scrollTo(0, 0);
    });


});