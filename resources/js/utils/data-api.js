import { useState, useEffect } from "react";
import axios from "axios";

const useDataApi = (initialUrl, initialData) => {
    const [data, setData] = useState(initialData);
    const [url, setUrl] = useState(initialUrl);
    const [isLoading, setIsLoading] = useState(false);
    const [isError, setIsError] = useState(false);
    if (!url.includes("undefined")) {
        useEffect(() => {
            const fetchData = async () => {
                setIsError(false);
                setIsLoading(true);

                try {
                    const result = await axios(url);

                    setData({
                        records: result.data
                    });
                } catch (error) {
                    setIsError(true);
                }

                setIsLoading(false);
            };

            fetchData();
        }, [url]);
    }
    return [{ data, isLoading, isError }, setUrl];
};

export default useDataApi;
