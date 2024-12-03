export const uploadCsvFile = async (file) => {
    const formData = new FormData();
    formData.append("file", file);

    try {
        const response = await fetch("/api/", {
            method: "POST",
            body: formData,
        });

        if (!response.ok) {
            throw new Error(await response.text());
        }

        return await response.json();
    } catch (error) {
        throw new Error(error.message || "An error occurred while uploading the file.");
    }
};
