/*
 * Send new user choice, then recieve object where define what need to change
 * and change selects
 */

function GetGroupAttributes(group) {
        $.ajax({
                url:"groupattr",
                type:'POST',
                data: {
                        group_id: group
                },
                success: ShowAttributes
        });
}

function GetCategoryGroups(category, targetUrl) {
        $.ajax({
                url:targetUrl,
                type:'POST',
                data: {
                        cat_id: category
                },
                success: function(data){
                        $("#Attr_attr_group_id").html(data);
                        GetGroupAttributes($("#Attr_attr_group_id").val());
                }
        });
}


function ShowAttributes(data)
{
        $("#group-attr").html(data);
}

function UpdateSelect(data, select)
{
        select.find('option').remove();
        select.removeAttr('disabled');
        select.append($("<option></option>").attr("value","0").text(" "));
        $.each(data, function(key, value)
        {
                select.
                append($("<option></option>").
                        attr("value",key).
                        text(value));
        });
        select.trigger("onUpdate");
}

function CreateAttr(name, group, ismain, type, pos) {
        $.ajax({
                url:'create',
                type:'POST',
                data: {
                        name: name,
                        group:group,
                        ismain:ismain,
                        type:type,
                        pos:pos
                },
                success: function(html){
                        $(".ajax-result").html(html).css({
                                "opacity":"1"
                        }).animate({
                                opacity: '0'
                        }, 3000);
                        GetGroupAttributes($("#Attr_attr_group_id").val());
                }
        });
}
