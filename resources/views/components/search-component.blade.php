
@props(['route'])

<div class="relative">
  <form action="{{ route($route) }}">
    <label for="Search" class="sr-only"> Search </label>
  
    <input
      type="text"
      id="Search"
      name="search"
      value="{{ request('search') }}"
      placeholder="Search for..."
      class="w-full dark:bg-slate-500 dark:text-white placeholder:dark:text-gray-100 rounded-md border-gray-200 py-2.5 pe-10 shadow-sm sm:text-sm"
    ></input>
  
    <span class="absolute inset-y-0 end-0 grid w-10 place-content-center">

        <button  type="submit" class="text-gray-600 hover:text-gray-700 dark:text-gray-200 hover:dark:text-white">
          <span class="sr-only">Search</span>
          
          <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke-width="1.5"
          stroke="currentColor"
          class="h-4 w-4"
          >
          <path
          stroke-linecap="round"
          stroke-linejoin="round"
          d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"
          />
        </svg>
      </button>
    </span>
  </form>
  </div>