import { useState, useEffect } from "react";
import ax from "../api/api";

function SearchBox() {
  const [keyword, setKeyWord] = useState("");
  const [isLoading, setIsLoading] = useState(false);
  const [result, setResult] = useState([]);

  useEffect(() => {
    if (!keyword) {
      setResult([]);
      return;
    }

    const delayDebounce = setTimeout(() => {
      setIsLoading(true);
      ax.get(`/products/search?q=${keyword}`)
        .then((res) => setResult(res.data.products))
        .catch((err) => console.error(err))
        .finally(() => setIsLoading(false));
    }, 300);

    return () => clearTimeout(delayDebounce);
  }, [keyword]);

  return (
    <>
      <form className="max-w-md mx-auto my-4">
        <label className="block mb-2.5 text-sm font-medium text-heading sr-only ">
          Search
        </label>
        <div className="relative">
          <div className="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
            <svg
              className="w-4 h-4 text-body"
              aria-hidden="true"
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="24"
              fill="none"
              viewBox="0 0 24 24"
            >
              <path
                stroke="currentColor"
                strokeLinecap="round"
                strokeWidth="2"
                d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"
              />
            </svg>
          </div>
          <input
            type="search"
            id="search"
            className="block w-full p-3 ps-9 bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand shadow-xs placeholder:text-body"
            placeholder="Search"
            required
            value={keyword}
            onChange={(e) => setKeyWord(e.target.value)}
          />
          <button
            type="button"
            onClick={() => {
              console.log("searching...");
              console.log(`show loading indicator ${isLoading}`);
              console.log(`update ui to show results ${result}`);
            }}
            className="absolute end-1.5 bottom-1.5 text-white bg-btn-orange hover:bg-brand-strong box-border border border-transparent focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded text-xs px-3 py-1.5 focus:outline-none"
          >
            Search
          </button>
        </div>
      </form>
    </>
  );
}

export default SearchBox;
