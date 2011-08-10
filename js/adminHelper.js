/**
 * Created by JetBrains PhpStorm.
 * User: alexk984
 * Date: 10.08.11
 * Time: 14:34
 */

function EditBrand(link){
    $("#Brand_id").val(link.parent('td').parent('tr').find('td').html());
    $("#Brand_name").val(link.parent('td').parent('tr').find('td').next('td').html());
}