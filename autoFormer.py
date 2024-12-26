import os
import time
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.edge.service import Service  # Import Service for Edge
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.chrome.options import Options

options = Options()
options.add_argument("--verbose")
driver = webdriver.Edge(options=options)

# Define the form URL
form_link = "https://docs.google.com/forms/d/e/1FAIpQLSclG7ZCq7wLCBUxUNs1USu3cRL4zv34C0kmxnvNafPQp9jrvA/viewform"

# Define responses for the survey
all_data = [
    {
        "use_phone_case": "Yes",
        "priority": ["Protection", "Price"],
        "purchase_frequency": "Monthly",
        "prefer_local": "No",
        "customize_features": ["Colors", "Materials"],
        "willing_to_pay": "PHP 300-500",
        "value_ecofriendly": "4",
        "interested_accessories": "Yes",
        "age_group": "21-25",
        "design_online": "Yes",
        "recommend_case": "Yes",
        "recommend_scale": "5",
        "discount_encourage": "Yes",
        "protection_style": "Yes",
        "check_reviews": "Yes"
    },
    # Add more dictionaries for additional submissions
]

def initialize_browser():
    # Set Edge options
    options = webdriver.EdgeOptions()
    options.add_argument("--inprivate")  # InPrivate browsing (similar to incognito in Chrome)
    # options.add_argument("--headless")  # Uncomment if you want to run in headless mode

    # Path to Edge WebDriver
    DRIVER_PATH = os.path.join(os.getcwd(), "msedgedriver.exe")  # Adjust path as needed

    # Initialize the Service object for Edge
    service = Service(executable_path=DRIVER_PATH)

    # Initialize the WebDriver with the Service object and options
    browser = webdriver.Edge(service=service, options=options)
    return browser

def fill_radio_option(browser, question_number, option_text):
    """
    Fills a single-choice question.
    """
    try:
        # Construct XPath based on question number and option text
        xpath = f'(//div[@role="listitem"])[{question_number}]//span[text()="{option_text}"]'
        option = WebDriverWait(browser, 10).until(
            EC.element_to_be_clickable((By.XPATH, xpath))
        )
        option.click()
    except Exception as e:
        print(f"Error selecting radio option for question {question_number}: {e}")

def fill_checkbox_option(browser, question_number, options_list):
    """
    Fills a multiple-choice (checkbox) question.
    """
    try:
        for option_text in options_list:
            xpath = f'(//div[@role="listitem"])[{question_number}]//span[text()="{option_text}"]'
            option = WebDriverWait(browser, 10).until(
                EC.element_to_be_clickable((By.XPATH, xpath))
            )
            option.click()
            time.sleep(1)  # Add a delay to ensure the option is clicked before proceeding

        # After filling in the checkbox options, pause here to avoid moving too quickly
        time.sleep(2)  # Add extra wait to ensure the selections are registered properly
    except Exception as e:
        print(f"Error selecting checkbox option for question {question_number}: {e}")


def fill_scale(browser, question_number, scale_value):
    """
    Fills a scale question.
    """
    try:
        # Assuming scale_value is the label text (e.g., "1", "2", ..., "5")
        xpath = f'(//div[@role="listitem"])[{question_number}]//span[text()="{scale_value}"]'
        option = WebDriverWait(browser, 10).until(
            EC.element_to_be_clickable((By.XPATH, xpath))
        )
        option.click()
    except Exception as e:
        print(f"Error selecting scale option for question {question_number}: {e}")

def fill_textbox(browser, question_number, text):
    """
    Fills a textbox question.
    """
    try:
        xpath = f'(//div[@role="listitem"])[{question_number}]//textarea'
        textbox = WebDriverWait(browser, 10).until(
            EC.presence_of_element_located((By.XPATH, xpath))
        )
        textbox.send_keys(text)
    except Exception as e:
        print(f"Error filling textbox for question {question_number}: {e}")

def submit_form(browser):
    """
    Submits the form.
    """
    try:
        submit_xpath = '//span[text()="Submit"]'
        submit_button = WebDriverWait(browser, 10).until(
            EC.element_to_be_clickable((By.XPATH, submit_xpath))
        )
        submit_button.click()
    except Exception as e:
        print(f"Error clicking submit button: {e}")

def reset_form(browser):
    """
    Clicks the 'Submit another response' link to reset the form.
    """
    try:
        another_xpath = '//a[contains(text(), "Submit another response")]'
        another_link = WebDriverWait(browser, 10).until(
            EC.element_to_be_clickable((By.XPATH, another_xpath))
        )
        another_link.click()
    except Exception as e:
        print(f"Error clicking 'Submit another response' link: {e}")

def main():
    browser = initialize_browser()
    browser.get(form_link)

    for entry in all_data:
        time.sleep(2)  # Wait for the form to load

        # Question 1: Do you currently use a phone case? (Single Choice)
        fill_radio_option(browser, 1, entry["use_phone_case"])

        # Question 2: What do you prioritize most when choosing a phone case? (Multiple Choice)
        fill_checkbox_option(browser, 2, entry["priority"])

        # Question 3: How often do you purchase phone cases? (Single Choice)
        fill_radio_option(browser, 3, entry["purchase_frequency"])

        # Question 4: Would you prefer a phone case made by a local business over a large brand? (Yes/No)
        fill_radio_option(browser, 4, entry["prefer_local"])

        # Question 5: What features would you like to customize on a phone case? (Checkboxes)
        fill_checkbox_option(browser, 5, entry["customize_features"])

        # Question 6: How much would you be willing to pay for a high-quality, customized phone case? (Single Choice)
        fill_radio_option(browser, 6, entry["willing_to_pay"])

        # Question 7: How much do you value eco-friendly or sustainable packaging for phone cases? (Scale 1-5)
        fill_scale(browser, 7, entry["value_ecofriendly"])

        # Question 8: Would you be interested in other customizable accessories (like tablet covers or laptop skins)? (Yes/No)
        fill_radio_option(browser, 8, entry["interested_accessories"])

        # Question 9: What age group do you fall into? (Single Choice)
        fill_radio_option(browser, 9, entry["age_group"])

        # Question 10: Would you like to design your phone case using an online platform or app? (Yes/No)
        fill_radio_option(browser, 10, entry["design_online"])

        # Question 11: Would you recommend a customizable phone case to friends or family? (Yes/No)
        fill_radio_option(browser, 11, entry["recommend_case"])

        # Question 12: On a scale of 1-5, how likely are you to recommend a high-quality, customizable phone case to friends or family? (Scale 1-5)
        fill_scale(browser, 12, entry["recommend_scale"])

        # Question 13: Would a discount or promotion encourage you to buy a customized phone case? (Yes/No)
        fill_radio_option(browser, 13, entry["discount_encourage"])

        # Question 14: Do you prefer a phone case that combines both protection and style? (Yes/No)
        fill_radio_option(browser, 14, entry["protection_style"])

        # Question 15: Do you check customer reviews or testimonials before purchasing a customized phone case? (Yes/No)
        fill_radio_option(browser, 15, entry["check_reviews"])

        # Submit the form
        submit_form(browser)

        # Optional: Reset the form for the next entry
        time.sleep(2)  # Wait for submission to process
        reset_form(browser)
        time.sleep(2)  # Wait for the form to reset

    # Close the browser after all submissions
    browser.quit()

if __name__ == "__main__":
    main()
