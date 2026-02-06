// a loading component that shows a skeleton of the UI while data is loading

function LoadingSkeleton() {
  return (
    <div className=" animate-pulse w-full h-full">
      <div className="border-default mb-6 h-20 rounded-2xl bg-gray-400"></div>
      {/* a list of loading skeleton items */}
      <div className="flex flex-col gap-3">
        <div className="m-2 h-16 rounded-3xl bg-gray-300"></div>
        <div className="m-2 h-16 rounded-3xl bg-gray-300"></div>
        <div className="m-2 h-16 rounded-3xl bg-gray-300"></div>
        <div className="m-2 h-16 rounded-3xl bg-gray-300"></div>
        <div className="m-2 h-16 rounded-3xl bg-gray-300"></div>
      </div>
    </div>
  );
}

export default LoadingSkeleton;
