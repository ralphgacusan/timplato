# Timplato Classroom Demo and Testing Guide

## Purpose

This walkthrough uses the Timplato training storefront with fictional accounts, sample products, practice reviews, and simulated checkout. No real customer information or real payments are needed. The training copy has simplified behavior and is not a production-store template.

## Preparation

1. Open the prepared local or isolated classroom test instance.
2. Prepare the storefront and training data viewer in separate browser tabs.
3. Use fictional names and email addresses ending in `example.test`.
4. If a fresh dataset is needed, use **Reset lab data** in the viewer. This removes existing training accounts and reviews and restores sample data.
5. Close unrelated tabs before capturing screenshots.

The practice account displayed on the sign-in page is `demo@example.test` with password `LabPassword123!`. Use this password only for the practice account.

## Demo pages

Paths are relative to the prepared test instance.

| Page | Path | Purpose |
| --- | --- | --- |
| Sign in | `/signin-test` | Show accepted and incorrect credentials |
| Create account | `/signup-test` | Register a fictional practice account |
| Products | `/products-test` | Browse the sample catalog |
| Product details | `/product-test/1` | View a sample product and reviews |
| Cart | `/cart-test` | Review items and try simulated checkout |
| Training data viewer | `/database-test` | Inspect sample records and reset the dataset |

## Presentation sequence: 8 to 10 minutes

### 1. Introduce the project

Say: "Timplato is our kitchenware storefront project. We are using a training copy with fictional records to demonstrate the shopping workflow and record basic test observations."

### 2. Show sign-in feedback

Sign in using the displayed practice account, show the response, and log out. Repeat with `visitor@example.test` and an incorrect practice password. Explain the feedback shown by the page.

### 3. Register a practice account

Use `Demo Student` as the name and `student01@example.test` as the email. Choose a disposable practice password and complete the confirmation field. Submit the form, record its response, and try signing in with the new account.

### 4. Browse and use the cart

Open the catalog and select a product. Explain its name, price, and availability. Add it to the cart and review the item and quantity. Use the simulated checkout control and record the resulting message. This demonstration does not involve a real payment or delivery.

### 5. Submit a review

Submit a plain-text comment such as: "Sample review for our classroom demonstration." Refresh the product page and check whether it remains visible. Clear the practice review afterward if needed.

### 6. Explain the sample records

Refresh the training data viewer after registration or review submission. Connect the visible sample records to actions performed in the interface. The viewer refreshes manually.

### 7. Clean up

Log out. If saved practice records are no longer needed, use **Reset lab data** and check the restored sample catalog. Review the cart separately and remove remaining items if necessary.

## Test checklist

These are observations to check, not completed test results.

| ID | Action | Expected observation | Actual result | Status |
| --- | --- | --- | --- | --- |
| D01 | Use the displayed practice sign-in | Successful sign-in feedback | To record | Not run |
| D02 | Submit incorrect practice credentials | Unsuccessful sign-in feedback | To record | Not run |
| D03 | Register a fictional account | Registration response appears | To record | Not run |
| D04 | Open a product | Product details appear | To record | Not run |
| D05 | Add an item to the cart | Selected item appears | To record | Not run |
| D06 | Use simulated checkout | Simulation feedback appears | To record | Not run |
| D07 | Submit a plain-text review and refresh | Review remains visible | To record | Not run |
| D08 | Refresh the data viewer | Current sample records appear | To record | Not run |
| D09 | Reset the training dataset | Practice records clear and sample data returns | To record | Not run |

Record Pass, Fail, or Not run with a short observation. Record unexpected behavior as a finding rather than changing the expected result to match it.

## Evidence for the class report

Capture the catalog, cart, practice review, and relevant form feedback. Label screenshots with their test IDs. Record the presentation date, presenter, and test instance. Keep passwords, configuration files, and unrelated personal information out of screenshots.

## Troubleshooting

- Training pages unavailable: have the person preparing the instance check `SECURITY_TESTING_ENABLED`. Cached configuration changes require restarting the instance.
- Practice account unavailable: reset the training dataset if existing practice records are no longer needed, then retry the credentials displayed on the page.
- Viewer shows old records: refresh it after submitting a form.
- Records disappear after redeployment: sample storage may be replaced unless persisted; prepare the dataset again before presenting.
- Results differ from expectations: record the actual behavior and continue with the next independent step.

## Learning outcomes

Explain the shopping workflow, connect interface actions with sample records, distinguish expected results from observations, and present a repeatable demonstration using fictional information.
