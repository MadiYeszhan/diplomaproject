<nav class="col-md-2 d-none d-md-block mt-5 ml-5 rounded">
    <div class="card mb-5">
        <div class="card-header">
            Admin panel
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item"> <a href="{{route('admin.index')}}">Main</a> </li>
        </ul>
    </div>
    <div class="card mb-5">
        <div class="card-header">
            Databases
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item"> <a href="{{route('drugs.index')}}">Drugs</a></li>
            <li class="list-group-item"> <a href="{{route('diseases.index')}}">Diseases</a></li>
            <li class="list-group-item"> <a href="{{route('drug_categories.index')}}">Drug Categories</a></li>
            <li class="list-group-item"> <a href="{{route('disease_categories.index')}}">Disease Categories</a></li>
            <li class="list-group-item"> <a href="{{route('manufacturers.index')}}">Manufactures</a></li>
        </ul>
    </div>
</nav>
