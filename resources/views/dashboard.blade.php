<x-layout>
 <h1>Dashboard</h1>
    <p>Welcome to {{ Auth::user()->name }}</p>
    
    <form action="/logout" method="POST">
        @csrf
        <button>Log out</button>
    </form>
</x-layout>