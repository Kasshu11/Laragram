import './bootstrap';


function delete_alert(e){
    if(!window.confirm('削除します。よろしいですか？(この操作は取り消せません）')){
       window.alert('キャンセルされました'); 
       return false;
    }
    document.deleteform.submit();
 };
 1
 2
 3
 4
 5
 6
 7
 function delete_alert(e){
    if(!window.confirm('削除します。よろしいですか？(この操作は取り消せません）')){
       window.alert('キャンセルされました'); 
       return false;
    }
    document.deleteform.submit();
 };