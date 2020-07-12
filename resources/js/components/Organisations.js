import React from "react";
import { Container } from "react-bootstrap";
import { Link } from "react-router-dom";
import Table from "react-bootstrap/Table";
import useDataApi from "../utils/data-api";

export default function Organisations() {
    const [{ data, isLoading, isError }, doFetch] = useDataApi(
        "/organisations",
        {
            records: []
        }
    );

    return (
        <Container fluid>
            {isError && <div>Something went wrong ...</div>}
            {isLoading ? (
                <div>Loading ...</div>
            ) : (
                <Table responsive="sm">
                    <thead>
                        <tr>
                            <th>Organisation ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        {console.log(data)}
                        {data.records.map(org => (
                            <tr key={org.id}>
                                <td>{org.id}</td>
                                <td>{org.name}</td>
                                <td>{org.description}</td>
                                <td>
                                    <Link to={`/org-store/${org.id}`}>
                                        Edit
                                    </Link>
                                    {" | "}
                                    <Link to={`/org-delete/${org.id}`}>
                                        Delete
                                    </Link>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </Table>
            )}
        </Container>
    );
}
