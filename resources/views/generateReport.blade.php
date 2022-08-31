@extends('layout.app')
@section('content')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

<script language="javascript">
    function Clickheretoprint()
    { 
      var disp_setting="toolbar=yes,location=no,directories=yes,menubar=yes,"; 
          disp_setting+="scrollbars=yes,width=800, height=800, left=300, top=55"; 
      var content_vlue = document.getElementById("print_content").innerHTML; 
      
      var docprint=window.open("","",disp_setting); 
       docprint.document.open(); 
       docprint.document.write('<html><head><title>USCF KICUKIRO SECTOR REPORT</title>'); 
       docprint.document.write('</head><body onLoad="self.print()" style="width: 800px; font-size:5px; font: 7px verdana><table>');          
       docprint.document.write(content_vlue);          
       docprint.document.write('</table></body></html>'); 
       docprint.document.close(); 
       docprint.focus(); 
    }
    
    </script><body>
    <div class="container mt-5">
        <div style="padding-top: 20px"></div>
        <h2 class="text-center mb-3">Report</h2>

        <div class="d-flex justify-content-end mb-4">
            <button class="btn btn-default"><a href="javascript:Clickheretoprint()"  style="text-decoration: none;">PRINT</a></button>
        </div>
        <div id="print_content">
        <table class=" table table-bordered mb-5 bg-white" >
            <thead>
                <tr class="table-danger">
                    <th scope="col">#</th>
                    <th scope="col">First name</th>
                    <th scope="col">Last name</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Cell</th>
                    <th scope="col">House</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                <?=$count = 1;?>
                @foreach($data ?? '' as $datas)
                <tr>
                    <th scope="row">{{$count++ }}</th>
                    <td>{{ $datas->first_name }}</td>
                    <td>{{ $datas->last_name }}</td>
                    <td>{{ $datas->phone }}</td>
                    <td>{{ $datas->cell_name }}</td>
                    <td>{{ $datas->house_code }}</td>
                    <td>{{ $datas->amount }}</td>
                    <td>{{ $datas->paid==1? "Paid":"Not Paid" }}</td>
                   
                </tr>
               
                @endforeach
            </tbody>
        </table>
        </div>
    </div>

   
</body>

</html>
@endsection


    