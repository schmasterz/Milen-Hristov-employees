import React, { useState } from "react";
import { Container, Row, Col, Table, Alert } from "react-bootstrap";
import { uploadCsvFile } from "../../Services/ApiService";

const Index = () => {
    const [dragActive, setDragActive] = useState(false);
    const [uploadedData, setUploadedData] = useState([]);
    const [error, setError] = useState("");

    const handleDrag = (e) => {
        e.preventDefault();
        e.stopPropagation();
        if (e.type === "dragenter" || e.type === "dragover") {
            setDragActive(true);
        } else if (e.type === "dragleave") {
            setDragActive(false);
        }
    };

    const handleDrop = async (e) => {
        e.preventDefault();
        e.stopPropagation();
        setDragActive(false);

        const file = e.dataTransfer.files[0];
        if (!file) {
            setError("No file uploaded.");
            return;
        }
        if (file.type !== "text/csv") {
            setError("Please upload a valid CSV file.");
            return;
        }

        try {
            const data = await uploadCsvFile(file);
            setUploadedData(data);
            setError("");
        } catch (err) {
            setError(err.message);
        }
    };

    return (
        <Container>
            <Row className="my-4">
                <Col>
                    <div
                        className={`border p-5 text-center ${
                            dragActive ? "bg-light" : ""
                        }`}
                        onDragEnter={handleDrag}
                        onDragOver={handleDrag}
                        onDragLeave={handleDrag}
                        onDrop={handleDrop}
                    >
                        <h5>Drag and drop your CSV file here</h5>
                        <p>or click to select a file</p>
                        <input
                            type="file"
                            id="fileUploadInput"
                            hidden
                            onChange={(e) => {
                                handleDrop({
                                    dataTransfer: { files: e.target.files },
                                    preventDefault: () => {},
                                    stopPropagation: () => {},
                                });
                            }}
                        />
                        <label
                            htmlFor="fileUploadInput"
                            className="btn btn-primary mt-2"
                        >
                            Browse CSV File
                        </label>
                    </div>
                </Col>
            </Row>

            {error && (
                <Alert variant="danger" className="mt-4">
                    {error}
                </Alert>
            )}

            {uploadedData.length > 0 && (
                <Row className="mt-4">
                    <Col>
                        <h5>Employee Pair Data</h5>
                        <Table striped bordered hover>
                            <thead>
                            <tr>
                                <th>Employee #1</th>
                                <th>Employee #2</th>
                                <th>Days Worked</th>
                            </tr>
                            </thead>
                            <tbody>
                            {uploadedData.map((row, index) => (
                                <tr key={index}>
                                    <td>{row.emp1}</td>
                                    <td>{row.emp2}</td>
                                    <td>{row.totalDaysWorked}</td>
                                </tr>
                            ))}
                            </tbody>
                        </Table>
                    </Col>
                </Row>
            )}
        </Container>
    );
};

export default Index;
