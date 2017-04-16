$(document).ready(function(){
    $('input.search').on('keyup',function(){

        var searchTerm = $(this).val().toLowerCase()
        var counter = 0

        $('table tbody tr').each(function(){
        
            var lineStr = $(this).text().toLowerCase()

            if(lineStr.indexOf(searchTerm) === -1){
                
                if($(this).hasClass('show')){
                	$(this).removeClass('show')
                }
                
                $(this).addClass('hide')

            }else{

                if($(this).hasClass('hide')){
                	$(this).removeClass('hide')
                }
                
                $(this).addClass('show')
            }

            if($(this).hasClass('show')){
            	counter++
            }      
        
        });

        if(counter == 0){
        	$('table').find('tfoot').detach()
        	$('table').append('<tfoot><tr><td>Data Not Found!</td></tr></tfoot>')
        }else{
			$('table tfoot').detach()
        }

    })


    $('thead th').click(function(){

        var table = $(this).parents('table').eq(0)
        var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()))
        
        this.asc = !this.asc

        if(!this.asc){
            rows = rows.reverse()
        }

        for(var i = 0; i < rows.length; i++) {
            table.append(rows[i])
        }
        
    })
});

function comparer(index){

	return function(a,b){
		
		var valA=getCellValue(a,index), valB=getCellValue(b,index)
		
		return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.localeCompare(valB)
	}

}

function getCellValue(row,index){

	return $(row).children('td').eq(index).html()

}