import React from "react";
import { Container } from "react-bootstrap";
import { BrowserRouter, Route, Switch, Link } from "react-router-dom";
import Table from "react-bootstrap/Table";
import useDataApi from "../utils/data-api";

export default function Users() {
    const [{ data, isLoading, isError }, doFetch] = useDataApi("/users", {
        records: []
    });

    return (
        <Container fluid>
            {isError && <div>Something went wrong ...</div>}
            {isLoading ? (
                <div>Loading ...</div>
            ) : (
                <Table responsive="sm">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Type</th>
                            <th>Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        {console.log(data)}
                        {data.records.map(user => (
                            <tr key={user.id}>
                                <td>{user.id}</td>
                                <td>{user.name}</td>
                                <td>{user.email}</td>
                                <td>{user.is_admin ? "Admin" : "Employee"}</td>
                                <td>
                                    <Link to={`/store/${user.id}`}>Edit</Link>
                                    {" | "}
                                    <Link to={`/delete/${user.id}`}>
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

Users.propTypes = {};
