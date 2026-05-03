<x-layout>
 <h1>Dashboard</h1>
    <p>Welcome to {{ Auth::user()->name }}</p>
    
     @foreach ($users as $user )
         <div>
                <p>Name: {{ $user->name }}</p>
            
         </div>
     @endforeach

    <form action="/logout" method="POST">
        @csrf
        <button>Log out</button>
    </form>
</x-layout>