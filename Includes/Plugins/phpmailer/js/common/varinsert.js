/*
This script is written for use with PHPMailer-ML when
using the SPAW Editor v.2. It is designed to add a menu option for
variable substitution within an email message body. To use it
you will require the file "inc.campaigns.php" for PHPMailer-ML
version 1.8.1a. 
Author: Andy Prevost
License: GPL (see docs/license.txt)
*/
function SpawPGvarinsert()
{
}

SpawPGvarinsert.change = function(editor, tbi, sender)
{
  if (tbi.is_enabled) {
    var cls = sender.options[sender.selectedIndex].value;
    if (!sender.selectedIndex||!cls) {
        return;
        editor.focus();    
    }
    var sel = editor.getNodeAtSelection();
    var update=false;
    if (sel)
    {
      /*
      if (sel.nodeType == 1) // element
      {
        // ?
        //editor.insertNodeAtSelection(cls);
      }
      else
      {
      */
        var pnode = editor.getSelectionParent();
        if (pnode && pnode.nodeType == 1 && pnode.tagName.toLowerCase() == 'span' ) // workaround for IE 
        {
          if (pnode.id.match('custom_drop_down') && pnode.id.match(/\d+/)) 
          {
            update=true;
          }
        }
        if (update) {
          pnode.innerHTML=cls;
          pnode.id='custom_drop_down_'+sender.selectedIndex;
        } else {
          var pdoc = editor.getActivePageDoc();
          var spn = pdoc.createElement("SPAN");
          var spt = pdoc.createTextNode(cls);
          spn.appendChild(spt);
          spn.id = 'custom_drop_down_'+sender.selectedIndex;
          editor.insertNodeAtSelection(spn);
        }
      /*
      }
      */
    }
    sender.selectedIndex = 0;
    editor.focus();
    return null;
  }
}

SpawPGvarinsert.isEnabled = function(editor, tbi)
{
  return editor.isInDesignMode();
}

SpawPGvarinsert.statusCheck = function(editor, tbi)
{
  var pnode = editor.getSelectionParent();
  if (pnode && pnode.tagName.toLowerCase() == 'span' ) // workaround for IE 
  {
    if (pnode.id.match('custom_drop_down')) 
    {
      var the_id=pnode.id.match(/\d+/);
      if (the_id) {
        return pnode.innerHTML;
        editor.updateToolbar();

      }
    }
  }
  return null;
}
