let rating_data = 0;
//let id=$(document).getElementById("id");
$('#add_review').click(function() {
    $('#review_modal').modal('show');
});
$(document).on('mouseenter', '.submit_star', function() {
    reset_background();
    for (let count = 1; count <= $(this).data('rating'); count++)
        $(`#submit_star_${count}`).addClass('text-warning');
});
$(document).on('mouseleave', '.submit_star', function() {
    reset_background();
    for (let count = 1; count <= rating_data; count++) {
        $(`#submit_star_${count}`).removeClass('star-light');
        $(`#submit_star_${count}`).addClass('text-warning');
    }
});
$(document).on('click', '.submit_star', function() {
    rating_data = $(this).data('rating');
});
$('#save_review').click(function(){
    let user_name = $('#user_name').val();
    let user_review = $('#user_review').val();
    if (user_name == '' || user_review == '')
        return alert("Il faut remplir les deux champs, s'il vous plait!");
    else
        $.ajax({
            url: 'submit_rating.php',
            method: 'POST',
            data: {
                action: 'write_data',
                rating_data,
                user_name,
                user_review
            },
            success: function(data) {
                $('#review_modal').modal('hide');
                $('#user_review').val(null);
                $('#user_name').val(null);
                reset_background();
                load_rating_data();
            }
        });
});

function reset_background() {
    for (let count = 1; count <= 5; count++) {
        $(`#submit_star_${count}`).addClass('star-light');
        $(`#submit_star_${count}`).removeClass('text-warning');
    }
}
function load_rating_data() {
    $.ajax({
        url: 'submit_rating.php',
        method: 'POST',
        data: {
            action: 'load_data'
        },
        dataType: 'JSON',
        success: function(data) {
            let count_star = 0;
            $('#total_review').text(data.total_review);
            $('#average_rating').text(data.average_rating);
            $('.main_star').each(function() {
                if (++count_star <= data.average_rating)
                    $(this).addClass('text-warning');
            });
            console.log(data.stars_review);
            for (let count = 1; count <= 5; count++) {
                $(`#total_${count}_star_review`).text(data.star_reviews[count]);
                $(`#${count}_star_progress`).css('width', (data.star_reviews[count] / data.total_review) * 100 + '%');
            }
            $('#total_2_star_review').text(data.two_star_review);
            $('#2_star_progress').css('width', (data.two_star_review / data.total_review) * 100 + '%');
            $('#total_3_star_review').text(data.three_star_review);
            $('#3_star_progress').css('width', (data.three_star_review / data.total_review) * 100 + '%');
            $('#total_4_star_review').text(data.four_star_review);
            $('#4_star_progress').css('width', (data.four_star_review / data.total_review) * 100 + '%');
            $('#total_5_star_review').text(data.five_star_review);
            $('#5_star_progress').css('width', (data.five_star_review / data.total_review) * 100 + '%');

            if (data.review_data.length > 0) {
                let html = '';
                for (let count = 0; count < data.review_data.length; count++) {
                    let stars = '';
                    for (let star = 1; star <= 5; star++) {
                        let class_name = '';
                        if (star <= data.review_data[count].rating)
                            class_name = 'text-warning';
                        stars += `<i class="fas fa-star star-light ${class_name} mr-1"></i>`;
                    }
                    html +=
                    `<div class="row mb-3">
                        <div class="col-sm-1">
                            <div class="rounded-circle bg-danger text-white d-flex align-items-center justify-content-center" style="width:60px; height:60px;">
                                <h3 class="text-center">
                                    ${data.review_data[count].user_name.charAt(0)}
                                </h3>
                            </div>
                        </div>
                        <div class="col-sm-11">
                            <div class="card">
                                <div class="card-header">
                                    <b>${data.review_data[count].user_name}</b>
                                </div>
                                <div class="card-body">
                                    ${stars}<br/>${data.review_data[count].user_review}
                                </div>
                                <div class="card-footer text-right">
                                    ${data.review_data[count].datetime}
                                </div>
                            </div>
                        </div>
                    </div>`
                }
                $('#review_content').html(html);
            }
        }
    });
}

load_rating_data();