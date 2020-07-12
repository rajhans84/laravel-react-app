import React, { useState, useEffect } from "react";
import { Container } from "react-bootstrap";
import { useParams } from "react-router-dom";

import ErrorMessage from "./ErrorMessage";
import Success from "./Success";

function Delete({ url }) {
    console.log("params from path:", url);
    const [isLoading, setIsLoading] = useState(false);
    const [isError, setIsError] = useState(false);
    const [isSuccess, setIsSuccess] = useState(false);

    useEffect(() => {
        setIsError(false);
        setIsLoading(true);
        axios
            .delete(url)
            .then(res => {
                console.log(res);
                setIsSuccess(true);
            })
            .catch(error => {
                console.log(error);
                setIsError(true);
            });
        setIsLoading(false);
    }, [url]);

    return (
        <Container fluid>
            {isError && <ErrorMessage />}
            {isSuccess && <Success />}
            {isLoading && <div>Loading ...</div>}
        </Container>
    );
}

export function DeleteOrg() {
    let { id } = useParams();
    return <Delete url={`/organisations/${id}`} />;
}

export function DeleteUser() {
    let { id } = useParams();
    return <Delete url={`/users/${id}`} />;
}
