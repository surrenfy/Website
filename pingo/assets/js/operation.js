function $(eleStr){
        switch(eleStr.substr(0,1)){
        case "#":
            return document.getElementById(eleStr.substr(1));
            break;
        case ".":
            return document.getElementsByClassName(eleStr.substr(1));
            break;
        case "_":
            return document.getElementsByName(eleStr.substr(1));
            break;
        default:
            return document.getElementsByTagName(eleStr);
        break;
        }
    }

    onload = function(){

        doOperator();       
    }

    function doOperator(){

        var updates =$(".update");
        var dels =$(".del");
        for (var i = 0; i < dels.length; i++) {
            dels[i].onclick =   function(){
                if(confirm("�Ƿ�ȷ��ɾ����")){  //��ʾ�Ƿ�ɾ��
                    //var row = this.parentNode.parentNode; //ȡ��tr����
                    //row.parentNode.removeChild(row);  //�Ƴ�tr
                    $("#stuRecordTable").deleteRow(this.parentNode.parentNode.rowIndex);
                }
            }
            updates[i].onclick = function(){
                var operatorCell = this.parentNode.parentNode.getElementsByTagName("td")[1]; //ȡ��Ҫ������td����
                //1.�޸İ�ť�����������ܣ��޸ģ�ȷ���޸�
                if(this.value == "�޸�"){
                    this.value = "ȷ��";
                    operatorCell.innerHTML ="<input value='"+operatorCell.innerHTML+"'/>";//�����ݱ���ı���
                    //���޸Ĳ���
                }else{
                    operatorCell.innerHTML =operatorCell.getElementsByTagName("input")[0].value;//���ı���������
                    this.value = "�޸�";
                    //��ȷ���޸�
                }
            }
        }
    }
    
   )
