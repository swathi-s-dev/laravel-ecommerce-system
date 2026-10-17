<!doctype html>
<html>
    <head>
        <title>Categories show</title>
        

    </head>
<body>
    <div class="header">
        <h1> Categories View</h1>
        <a href="{{route('categories.create')}}" class="add-btn">Add Category</a>
           <br>  <br>
     </div>
         @if (session('success'))
                <div class="success">
                    {{session('success')}}
                        
                </div>
            @endif

        <table border="2" cellpadding="5" width="75%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th style="width: 30%">Status</th>
                </tr>
            </thead>
            <tbody>
               @forelse ($categories as $category )
                    <tr>
                        <td>{{$category->name}}</td>
                        <td>
                            <span class="{{ $category->status ? 'status-active' : 'status-inactive' }}">
                                {{ $category->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>

                    </tr>  
                @empty

                    <tr>
                        <td colspan="3"style="text-align:center;">
                            No category found.
                        </td>
                    </tr>

                @endforelse
            </tbody>
        </table>
</body>
</html>           