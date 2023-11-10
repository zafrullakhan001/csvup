<!DOCTYPE html>
<html>
<head>
    <title>Upload CSV</title>
</head>
<body>

@if(session('success'))
    <div>{{ session('success') }}</div>
@elseif(session('error'))
<br>
<div><br> Something wrong, did not upload the csv file : {{ session('error') }}<br></div>
    <br>
@endif

<form method="POST" action="{{ url('/upload-csv') }}" enctype="multipart/form-data">
    @csrf
    <input type="file" name="csv_file" accept=".csv">
    <button type="submit">Upload CSV</button>
</form>

</body>
</html>
