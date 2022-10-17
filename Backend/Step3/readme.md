### For code quality, you can use some tools : which one and why (in a few words) ?

We can use several tools in harmony
- A CI to run tests automatically in a ISO prod environment
- A code coverage to ensure new code is tested
- A code sniffer to check that code respects the good practices
- A precommit hook to prevent a commit if code sniffer or code coverage does not satisfy the required

### You can consider to setup a ci/cd process : describe the necessary actions in a few words

- Ensure tests is played automatically after each commit and covers all the crucial part of the code
- Have a tester before merging on the develop branch
- In case of DD, automatically deploy the code in production after each commit on the master branch
- If not, possible to have another round of manual tests between the merge on master branch and the deployment in prod environment (e.g. on a test environment)
