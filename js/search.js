/*
 * Send new user choice, then recieve object where define what need to change
 * and change selects
 */

function SendSearchReg(resetPage) {
    $(".col1").css('opacity', '0.3');
    if (resetPage == null)
        $("form input#page").val("0");
    
    $.ajax({
        url:"/catalog/search",
        type:'POST',
        data: $("#search-from").serialize(),
        success: ShowSearchResult,
        complete: ReqComplete
    });
}

function ReqComplete(data) {
    $(".col1").css('opacity', '1');
}

function ShowSearchResult(data) {
    if (data != '') {
        $(".col1").html(data);
    }
    else
        $(".col1").html('Ничего не найдено по этим критериям');
}

function ShowAttrList(attrBlockId) {
    var attrBlock = $(attrBlockId);
    if (attrBlock.hasClass("fclose"))
        attrBlock.removeClass("fclose");
    else
        attrBlock.addClass("fclose");
}