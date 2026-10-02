export const CONTACT_ENDPOINT = "https://api.web3forms.com/submit";

export async function submitContact(formData) {
  const payload = Object.fromEntries(formData);
  for (const field of ["name", "email", "message"]) {
    payload[field] = String(payload[field] || "").trim();
    if (!payload[field]) {
      throw new Error("Please enter your name, email, and message.");
    }
  }
  payload.subject = String(payload.subject || "").trim() || "New website contact message";

  const controller = new AbortController();
  const timeout = setTimeout(() => controller.abort(), 15000);

  try {
    const response = await fetch(CONTACT_ENDPOINT, {
      method: "POST",
      headers: { "Content-Type": "application/json", Accept: "application/json" },
      body: JSON.stringify(payload),
      signal: controller.signal,
    });
    const result = await response.json();
    if (!response.ok || result.success !== true) {
      const message = result.message || result.body?.message;
      throw new Error(typeof message === "string" ? message : "The email service could not send your message. Please try again later.");
    }
  } catch (error) {
    if (error.name === "AbortError" || error instanceof TypeError || error instanceof SyntaxError) {
      throw new Error("We couldn't confirm that your message was sent. Your text has been kept below. Please try again later or email me directly.");
    }
    throw error;
  } finally {
    clearTimeout(timeout);
  }
}
