import assert from "node:assert/strict";
import { test } from "node:test";
import { CONTACT_ENDPOINT, submitContact } from "../src/contactSubmission.js";

function contactData() {
  const data = new FormData();
  for (const [key, value] of Object.entries({
    access_key: "test-only-key",
    name: " Test Visitor ",
    email: " visitor@example.com ",
    subject: " ",
    message: " Please contact me about a project. ",
  })) data.set(key, value);
  return data;
}

test("sends the visitor's message and reply address and accepts confirmed success", async (t) => {
  const request = t.mock.method(globalThis, "fetch", async (url, options) => {
    assert.equal(url, CONTACT_ENDPOINT);
    assert.equal(options.method, "POST");
    assert.deepEqual(JSON.parse(options.body), {
      access_key: "test-only-key",
      name: "Test Visitor",
      email: "visitor@example.com",
      subject: "New website contact message",
      message: "Please contact me about a project.",
    });
    assert.equal(options.headers.Accept, "application/json");
    return Response.json({ success: true });
  });
  await submitContact(contactData());
  assert.equal(request.mock.callCount(), 1);
});

test("reports provider rejections even when the HTTP status is successful", async (t) => {
  t.mock.method(globalThis, "fetch", async () => Response.json({ success: false, message: "Invalid access key" }));
  await assert.rejects(submitContact(contactData()), /Invalid access key/);
});

test("reports nested provider errors and unsuccessful HTTP responses", async (t) => {
  t.mock.method(globalThis, "fetch", async () => Response.json({ body: { message: "Too many requests" } }, { status: 429 }));
  await assert.rejects(submitContact(contactData()), /Too many requests/);
});

test("does not report success for an unexpected service response", async (t) => {
  t.mock.method(globalThis, "fetch", async () => new Response("Service unavailable", { status: 503 }));
  await assert.rejects(submitContact(contactData()), /couldn't confirm/);
});

test("handles connection failures without retrying or changing the visitor's data", async (t) => {
  const data = contactData();
  const original = [...data.entries()];
  const request = t.mock.method(globalThis, "fetch", async () => { throw new TypeError("Failed to fetch"); });
  await assert.rejects(submitContact(data), /couldn't confirm/);
  assert.equal(request.mock.callCount(), 1);
  assert.deepEqual([...data.entries()], original);
});

test("rejects whitespace-only messages before contacting the service", async (t) => {
  const request = t.mock.method(globalThis, "fetch", async () => { throw new Error("Must not send"); });
  const data = contactData();
  data.set("message", "   ");
  await assert.rejects(submitContact(data), /Please enter/);
  assert.equal(request.mock.callCount(), 0);
});
